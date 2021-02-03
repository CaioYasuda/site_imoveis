<?php

    require_once("models/imoveis.php");
    require_once("models/message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/imovelDAO.php");
    require_once("globals.php");
    require_once("db.php");

    $message = new Message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);
    $imovelDAO = new ImovelDAO($conn, $BASE_URL);

    //Resgatar os dados do usuario 
    $userData = $userDAO->verifyToken();

    //Resgatar o tipo do formulario
    $type = filter_input(INPUT_POST, "type");

    if ($type === "create") {

        //Receber os dados dos imputs
        $title = filter_input(INPUT_POST, "title");
        $address = filter_input(INPUT_POST, "address");
        $city = filter_input(INPUT_POST, "city");
        $image = filter_input(INPUT_POST, "image");
        /*$image_2 = filter_input(INPUT_POST, "image_2");
        $image_3 = filter_input(INPUT_POST, "image_3");*/
        $measure = filter_input(INPUT_POST, "measure");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $description = filter_input(INPUT_POST, "description");

        $imovel = new Imovel();

        // Validação dados minimos
        if (!empty($title) && !empty($city) && !empty($measure) && !empty($category)) {

            $imovel->title = $title;
            $imovel->address = $address;
            $imovel->city = $city;
            $imovel->measure = $measure;
            $imovel->category = $category;
            $imovel->trailer = $trailer;
            $imovel->description = $description;
            $imovel->users_id = $userData->id;

            //Upload de imagem do imovel
            if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                //Chegando o tipo da imagem
                if (in_array($image["type"], $imageTypes)) {

                    //checa se imagem é jpg
                    if (in_array($image["type"], $jpgArray)) {
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    } else {
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }

                    //Gerando o nome da imagem
                    $imageName = $imovel->imageGenerateName();

                    imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                    $imovel->image = $imageName;

                } else {
                    $message->setMessage("Tipo invalido de imagem, insira png ou jpeg!", "error", "back");
                } 
            } 

            $imovelDAO->create($imovel);

        } else {
            $message->setMessage("Você precisa adicionar pelo menos: título, cidade, categoria e metragem", "error", "back");
        }

    } elseif ($type === "delete") {

        //Receber dados do formulario 
        $id = filter_input(INPUT_POST, "id");
        
        $imovel = $imovelDAO->findById($id);

        if($imovel) {

            //Verificar se o imovel é do usuario
            if($imovel->users_id === $userData->id) {

                $imovelDAO->destroy($imovel->id);

            } else {
                $message->setMessage("ERROR", "error", "index.php");
            }      

        } else {
            $message->setMessage("ERROR", "error", "index.php");
        }

    } elseif ($type === "update"){

        // Receber os dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $address = filter_input(INPUT_POST, "address");
        $city = filter_input(INPUT_POST, "city");
        $measure = filter_input(INPUT_POST, "measure");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $description = filter_input(INPUT_POST, "description");
        $image = filter_input(INPUT_POST, "image");
        $id = filter_input(INPUT_POST, "id");

        $imovelData = $imovelDAO->findById($id);

        // Verifica se encontrou o filme 
        if($imovelData) {

            // Verifica se o filme é do usuario
            if($imovelData->users_id === $userData->id) {

                //Validação dados minimos
                if(!empty($title) && !empty($city) && !empty($measure) && !empty($category)) {

                    //Edição do imovel
                    $imovelData->title = $title;
                    $imovelData->address = $address;
                    $imovelData->city = $city;
                    $imovelData->measure = $measure;
                    $imovelData->category = $category;
                    $imovelData->trailer = $trailer;
                    $imovelData->description = $description;
                    
                    //Upload de imagem do filme
                    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                        $image = $_FILES["image"];
                        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                        $jpgArray = ["image/jpeg", "image/jpg"];

                        //Chegando o tipo da imagem
                        if (in_array($image["type"], $imageTypes)) {

                            //checa se imagem é jpg
                            if (in_array($image["type"], $jpgArray)) {
                                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                            } else {
                                $imageFile = imagecreatefrompng($image["tmp_name"]);
                            }

                            //Gerando o nome da imagem
                            $movie = new Movie();
                            
                            $imageName = $imovel->imageGenerateName();

                            imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                            $imovelData->image = $imageName;

                        } else {
                            $message->setMessage("Tipo invalido de imagem, insira png ou jpeg!", "error", "back");
                        } 
                    } 

                    $imovelDAO->update($imovelData);

                } else {
                    $message->setMessage("Você precisa adicionar pelo menos: título, cidade, categoria e metragem", "error", "back");
                }

            } else {
                $message->setMessage("ERROR", "error", "index.php");
            }

        } else {
            $message->setMessage("ERROR", "error", "index.php");
        }


    } else {
        $message->setMessage("ERROR", "error", "index.php");
    }

?>