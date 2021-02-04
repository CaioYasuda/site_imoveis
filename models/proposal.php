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
        public function create(Proposta $proposal);
        public function getPropertieProposal($data);
        public function hasAlreadyProposed($id, $users_id);
        public function getPropose($data);

    }

?>