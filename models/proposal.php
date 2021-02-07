<?php

    class Proposal {

        public $id;
        public $value;
        public $name;
        public $lastname;
        public $phone;
        public $cpf;
        public $email;
        public $observations;
        public $users_id;
        public $imoveis_id;

    }

    interface ProposalDAOInterface {

        public function buildProposal($data);
        public function create(Proposal $proposal);
        public function getPropertieProposal($data);
        public function hasAlreadyProposed($id, $users_id);
        public function getPropose($data);
        public function proposalByImovel($id);
        public function buildImovel($data);
        public function getPropertirById($id);

    }

?>