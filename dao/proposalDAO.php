<?php 

    require_once("models/proposal.php");
    require_once("models/message.php");
    require_once("dao/UserDAO.php");

    class ProposalDAO implements ProposalDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new message($url);
        }

        public function buildProposal($data) {

        }

        public function create(Proposal $proposal) {

            $stmt = $this->conn->prepare("INSERT INTO tenders (
                name_buyer, lastname_buyer, value, cpf_buyer, phone_buyer, email_buyer, observations, properties_id, users_id
            ) VALUES (
                :name_buyer, :lastname_buyer, :value, :cpf_buyer, :phone_buyer, :email_buyer, :observations, :properties_id, :users_id
            )");

            $stmt->bindParam(":name_buyer", $proposal->name_buyer);
            $stmt->bindParam(":lastname_buyer", $proposal->lastname_buyer);
            $stmt->bindParam(":value", $proposal->value);
            $stmt->bindParam(":cpf_buyer", $proposal->cpf_buyer);
            $stmt->bindParam(":phone_buyer", $proposal->phone_buyer);
            $stmt->bindParam(":email_buyer", $proposal->email);
            $stmt->bindParam(":observations", $proposal->observations);
            $stmt->bindParam(":properties_id", $proposal->properties_id);
            $stmt->bindParam(":users_id", $proposal->users_id);

            $stmt->execute();

            //Mensagem de proposta enviada
            $this->message->setMessage("Sua proposta foi enviada com sucesso!", "success", "index.php"); 

        }

        public function getPropertieProposal($id) {

            $stmt = $this->conn->prepare("SELECT * FROM tenders WHERE properties_id = :properties_id");

            $stmt->bindParam(":properties_id", $id);

            $stmt->execute();

            $proposal = $stmt->rowCount();

            return $proposal;

        }

        public function hasAlreadyProposed($id, $userId) {

            $stmt = $this->conn->prepare("SELECT * FROM tenders WHERE properties_id = :properties_id AND users_id = :users_id");

            $stmt->bindParam(":properties_id", $id);
            $stmt->bindParam(":users_id", $userId);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        }

        public function getPropose($data) { 

        }

        public function proposalByImovel($id) {

            $properties = [];

            $stmt = $this->conn->prepare("SELECT * FROM tenders WHERE properties_id = :properties_id");

            $stmt->bindParam(":properties_id", $id);

            $stmt->execute();

            $propertieData = $stmt->fetchAll();

            return $propertieData;

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

        public function getPropertirById($id) {

            $propertieData = [];

            $stmt = $this->conn->prepare("SELECT * FROM properties WHERE id = :id");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $propertieData = $stmt->fetch();

                $propertie = $this->buildImovel($propertieData);

                return $propertie;

            } else {
                return false;
            }

        }

    }

?>
