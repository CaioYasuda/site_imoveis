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
            $imovel->rooms = $data["rooms"];
            $imovel->wc = $data["wc"];
            $imovel->value = $data["value"];
            $imovel->image = $data["image"];
            $imovel->users_id = $data["users_id"];

            return $imovel;

        }

        public function findAll() {

        }

        public function getLastestImovel() {

            $imoveis = [];

            $stmt = $this->conn->prepare("SELECT * FROM properties ORDER BY id DESC");

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $imovelArray = $stmt->fetchAll();

                foreach($imovelArray as $imovel) {
                    $imoveis[] = $this->buildImovel($imovel);
                }

            }

            return $imoveis;

        }

        public function getImovelByCategory($category) {

            $imoveis = [];

            $stmt = $this->conn->prepare("SELECT * FROM properties WHERE category = :category ORDER BY id DESC");

            $stmt->bindParam(":category", $category);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $imoveisArray = $stmt->fetchAll();

                foreach($imoveisArray as $imovel) {
                    $imoveis[] = $this->buildImovel($imovel);
                }
            }

            return $imoveis;

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
                title, address, city, measure, category, trailer, description, image, users_id, rooms, wc, value
            ) VALUES (
                :title, :address, :city, :measure, :category, :trailer, :description, :image, :users_id, :rooms, :wc, :value
            )");

            $stmt->bindParam(":title", $imovel->title);
            $stmt->bindParam(":address", $imovel->address);
            $stmt->bindParam(":city", $imovel->city);
            $stmt->bindParam(":measure", $imovel->measure);
            $stmt->bindParam(":category", $imovel->category);
            $stmt->bindParam(":trailer", $imovel->trailer);
            $stmt->bindParam(":description", $imovel->description);
            $stmt->bindParam(":rooms", $imovel->rooms);
            $stmt->bindParam(":wc", $imovel->wc);
            $stmt->bindParam(":value", $imovel->value);
            $stmt->bindParam(":image", $imovel->image);
            $stmt->bindParam(":users_id", $imovel->users_id);

            $stmt->execute();

            //Mensagem filme adicionado
            $this->message->setMessage("Imóvel adicionado com sucesso!", "success", "index.php");

        }

        public function update(Imovel $ImovelData) {

            $stmt = $this->conn->prepare("UPDATE properties SET 
                title = :title,
                address = :address,
                city = :city,
                measure = :measure,
                category = :category,
                trailer = :trailer,
                description = :description ,
                rooms = :rooms ,
                wc = :wc ,
                value = :value 
                WHERE id = :id
            ");

            $stmt->bindParam(":title", $imovelData->title);
            $stmt->bindParam(":address", $imovelData->address);
            $stmt->bindParam(":city", $imovelData->city);
            $stmt->bindParam(":measure", $imovelData->measure);
            $stmt->bindParam(":category", $imovelData->category);
            $stmt->bindParam(":trailer", $imovelData->trailer);
            $stmt->bindParam(":description", $imovelData->description);
            $stmt->bindParam(":rooms", $imovelData->rooms);
            $stmt->bindParam(":wc", $imovelData->wc);
            $stmt->bindParam(":value", $imovelData->value);
            $stmt->bindParam(":id", $imovelData->id);

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