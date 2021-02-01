<?php 

    require_once("models/user.php");
    require_once("models/message.php");
    require_once("globals.php");
    require_once("db.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $userDAO = new UserDAO($conn, $BASE_URL);

    //Resgata o tipo do formulario 
    $type = filter_input(INPUT_POST, "type");

    //Atualizar usuario
    if ($type === "update") {

        //Resgatar dados do usuario
        $userData = $userDAO->verifyToken();

        //Receber dados do post
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $phone = filter_input(INPUT_POST, "phone");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        //Criar novo objeto de usuario
        $user = new User();

        //Preencher os dados do usuario
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->phone = $phone;
        $userData->email = $email;
        $userData->bio = $bio;

        //upload da imagem 
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            //Checagem de tipo de imagem
            if (in_array($image["type"], $imageTypes)) {
                
                //Chegar se é jpg
                if (in_array($image["type"], $jpgArray)) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                //Imagem é png
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                $userData->image = $imageName;

            } else {
                $message->setMessage("Tipo invalido de imagem, insira png ou jpeg!", "error", "index.php");
            }

        }

        $userDAO->update($userData);

    } elseif ($type === "changepassword"){

        //Receber dados do usuario
        $userData = $userDAO->verifyToken();
        $id = $userData->id;

        if ($password == $confirmpassword) {

            $user = new User();

            $finalPassword = $user->generatePassword($password);

            $user->password = $finalPassword;
            $user->id = $id;

            $userDAO->changePassword($user);
            
        } else {
            $message->setMessage("As senhas não são iguais", "error", "back");
        }

    } else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }