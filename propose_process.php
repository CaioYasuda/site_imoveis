<?php 

    require_once("models/proposal.php");
    require_once("models/message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/imovelDAO.php");
    require_once("dao/proposalDAO.php");
    require_once("globals.php");
    require_once("db.php");

    $message = new Message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);
    $imovelDAO = new ImovelDAO($conn, $BASE_URL);
    $proposalDAO = new ProposalDAO($conn, $BASE_URL);

    //Resgatar os dados do usuario
    $userData = $userDAO->verifyToken();

    //Resgata o tipo do formulario 
    $type = filter_input(INPUT_POST, "type");


    if ($type === "create") {

        //Recebendo os dados
        $name_buyer = filter_input(INPUT_POST, "name_buyer");
        $lastname_buyer = filter_input(INPUT_POST, "lastname_buyer");
        $value = filter_input(INPUT_POST, "value");
        $cpf_buyer = filter_input(INPUT_POST, "cpf_buyer");
        $phone_buyer = filter_input(INPUT_POST, "phone_buyer");
        $email = filter_input(INPUT_POST, "email");
        $observations = filter_input(INPUT_POST, "observations");
        $properties_id = filter_input(INPUT_POST, "properties_id");
        $users_id = $userData->id;

        $proposalObject = new Proposal();

        $imovelData = $imovelDAO->findById($properties_id);

        //Validando se o imovel existe
        if($imovelData) {

            //Verificando os dados minimos
            if(!empty($name_buyer) && !empty($value) && !empty($phone_buyer)) {

                $proposalObject->name_buyer = $name_buyer;
                $proposalObject->lastname_buyer = $lastname_buyer;
                $proposalObject->value = $value;
                $proposalObject->cpf_buyer = $cpf_buyer;
                $proposalObject->phone_buyer = $phone_buyer;
                $proposalObject->email = $email;
                $proposalObject->observations = $observations;
                $proposalObject->properties_id = $properties_id;
                $proposalObject->users_id = $users_id;

                $proposalDAO->create($proposalObject);

            } else {
                $message->setMessage("Você precisa inserir o nome, valor e o telefone!", "error", "back");
            }

        } else {
            $message->setMessage("Informações inválidas!", "error", "index.php");
        }

    } else {
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }

?>