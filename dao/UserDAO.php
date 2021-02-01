<?php

    require_once("models/user.php");
    require_once("models/message.php");

    class UserDAO implements UserDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildUser($data) {

            $user = new User();

            $user->id = $data["id"];
            $user->name = $data["name"];
            $user->lastname = $data["lastname"];
            $user->email = $data["email"];
            $user->phone = $data["phone"];
            $user->password = $data["password"];
            $user->image = $data["image"];
            $user->bio = $data["bio"];
            $user->token = $data["token"];

            return $user;

        }

        public function create(User $user, $authUser = false) {

            $stmt = $this->conn->prepare("INSERT INTO user_properties(
                name, lastname, email, phone, password, token
              ) VALUES (
                :name, :lastname, :email, :phone, :password, :token
              )");
      
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":phone", $user->phone);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);
      
            $stmt->execute();
      
            // Autenticar usuário, caso auth seja true
            if($authUser) {
              $this->setTokenToSession($user->token);
            }

        }

        public function update(User $user, $redirect = true) {

            $stmt = $this->conn->prepare("UPDATE user_properties SET
                name = :name,
                lastname = :lastname,
                email = :email,
                phone = :phone,
                image = :image,
                bio = :bio,
                token = :token
                WHERE id = :id
            ");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":phone", $user->phone);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect) {

                // Redireciona para o perfil do usuario
                $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");

            }

        }

        public function verifyToken($protected = false) {

            if(!empty($_SESSION["token"])) {

                //Pega token da session
                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                if($user) {
                    return $user;
                } elseif($protected) {

                    // Redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");

                }

            } elseif($protected) {

                // Redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");

            }

        }

        public function setTokenToSession($token, $redirect = true) {

            // Salvar token na session
            $_SESSION["token"] = $token;

            if($redirect) {

                // Redireciona para o perfil do usuario
                $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

            }

        }

        public function authenticateUser($email, $password) {

            $user = $this->findByEmail($email);

            if($user) {

                // Checar se as senhas batem
                if(password_verify($password, $user->password)) {

                    // Gerar um token e inserir na session
                    $token = $user->generateToken();

                    $this->setTokenToSession($token, false);

                    // Atualizar token no usuário
                    $user->token = $token;

                    $this->update($user, false);

                    return true;

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function findByToken($token) {

            if ($token != "") {

                $stmt = $this->conn->prepare("SELECT * FROM user_properties WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function findByEmail($email) {

            if($email != "") {

                $stmt = $this->conn->prepare("SELECT * FROM user_properties WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function changePassword(user $user) { 

            $stmt = $this->conn->prepare("UPDATE user_properties SET password = :password WHERE id = :id");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            //Redirecionare apresentar msg de sucesso
            $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");

        }

        public function destroyToken() {

            // Remove o token da session
            $_SESSION["token"] = "";

            // Redirecionar e apresentar a mensagem de sucesso
            $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");

        }

    }
