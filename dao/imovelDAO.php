<?php 

    require_once("models/imoveis.php");
    require_once("models/message.php");

    class imovelDAO implements ImovelDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {

            $this->conn = $conn;
            $this->url = $url;
            $this->message = new message($url);
            
        }


        public function buildImovel($data) {

            $imovel = new Imovel();

            $imovel->id = $data["id"];
            $imovel->title = $data["title"];
            $imovel->address = $data["address"];
            $imovel->city = $data["city"];
            $imovel->measure = $data["measure"];
            $imovel->category = $data["category"];
            $imovel->trailer = $data["trailer"];
            $imovel->description = $data["description"];
            $imovel->image = $data["image"];
            $imovel->users_id = $data["users_id"];

            return $imovel;

        }

        public function findAll() {

        }

        public function getLastestImovel() {

        }

        public function getImovelByCategory($category) {

        }

        public function getImovelByUserId($id) {

            $imoveis = [];

            $stmt = $this->conn->prepare("SELECT * FROM properties WHERE users_id = :users_id");

            $stmt->bindParam(":users_id", $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $imoveisArray = $stmt->fetchAll();

                foreach ($imoveisArray as $imovel) {
                    $imoveis[] = $this->buildImovel($imovel);
                }

            }

            return $imoveis;

        }

        public function findById($id) {

            $imovel = [];

            $stmt = $this->conn->prepare("SELECT * FROM properties WHERE id = :id");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $imovelData = $stmt->fetch();

                $imovel = $this->buildImovel($imovelData);

                return $imovel;

            } else {
                return false;
            }

        }

        public function findByTitle($title) {

        }

        public function create(imovel $imovel) {

            $stmt = $this->conn->prepare("INSERT INTO properties (
                title, address, city, measure, category, trailer, description, image, users_id
            ) VALUES (
                :title, :address, :city, :measure, :category, :trailer, :description, :image, :users_id
            )");

            $stmt->bindParam(":title", $imovel->title);
            $stmt->bindParam(":address", $imovel->address);
            $stmt->bindParam(":city", $imovel->city);
            $stmt->bindParam(":measure", $imovel->measure);
            $stmt->bindParam(":category", $imovel->category);
            $stmt->bindParam(":trailer", $imovel->trailer);
            $stmt->bindParam(":description", $imovel->description);
            $stmt->bindParam(":image", $imovel->image);
            $stmt->bindParam(":users_id", $imovel->users_id);

            $stmt->execute();

            //Mensagem filme adicionado
            $this->message->setMessage("Imóvel adicionado com sucesso!", "success", "index.php");

        }

        public function update(Imovel $Imovel) {

            $stmt = $this->conn->prepare("UPDATE properties SET 
                title = :title,
                address = :address,
                city = :city,
                measure = :measure,
                category = :category,
                trailer = :trailer,
                description = :description 
                WHERE id = :id
            ");

            $stmt->bindParam(":title", $imovel->title);
            $stmt->bindParam(":address", $imovel->address);
            $stmt->bindParam(":city", $imovel->city);
            $stmt->bindParam(":measure", $imovel->measure);
            $stmt->bindParam(":category", $imovel->category);
            $stmt->bindParam(":trailer", $imovel->trailer);
            $stmt->bindParam(":description", $imovel->description);
            $stmt->bindParam(":id", $imovel->id);

            $stmt->execute();

            //Mensagem de anuncio alterado
            $this->message->setMessage("Anuncio atualizado com sucesso!", "success", "dashboard.php");
     
        }

        public function destroy($id) {

            $stmt = $this->conn->prepare("DELETE FROM properties WHERE id = :id");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            //Mensagem de imóvel excluido
            $this->message->setMessage("Imóvel removido com sucesso!", "success", "dashboard.php");

        }


    }


?>