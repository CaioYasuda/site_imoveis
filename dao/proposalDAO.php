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

        public function create(Proposta $proposal) {

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

    }

?>
