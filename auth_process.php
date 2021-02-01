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

    //verifica o tipo de formulario
    if ($type === "register") {

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $phone = filter_input(INPUT_POST, "phone");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
        
        //Verificação de dados minimos
        if ($name && $lastname && $email && $password && $phone) {

            //Verificar se as senhas batem
            if ($password === $confirmpassword) {

                //Verifica se o e-mail já está cadastrado
                if ($userDAO->findByEmail($email) === false) {

                    $user = new User();

                    //Criação de token e senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->phone = $phone;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    $auth = true;

                    $userDAO->create($user, $auth);

                } else {
                    //Enviar msg de erro, e-mail já existe
                    $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");
                }

            } else {
                //Enviar msg de erro, senhas são diferentes
                $message->setMessage("As senhas não são iguais.", "error", "back");
            }

        } else {
            //Enviar msg de erro, campos incompletos
            $message->setMessage("Por favor preencha todos os campos.", "error", "back");
        }


    } elseif ($type === "login") {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        //Tenta autenticar usuario
        if ($userDAO->authenticateUser($email, $password)) {

            $message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

        } else { //Caso não consiga autenticar
            $message->setMessage("Usuário e/ou senha incorretos", "error", "back");
        }

    } else {
        $message->setMessage("Error", "error", "index.php");
    }
