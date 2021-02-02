<?php

    class Imovel {

        public $id;
        public $title;
        public $description;
        public $address;
        public $city;
        public $image1;
        public $image2;
        public $image3;
        public $measure;
        public $category;
        public $trailer;
        public $users_id;

        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
        }

    }

    interface ImovelDAOInterface {

        public function buildImovel($data);
        public function findAll();
        public function getLastestImovel();
        public function getImovelByCategory($category);
        public function getImovelByUserId($id);
        public function findById($id);
        public function findByTitle($title);
        public function create(Imovel $imovel);
        public function update(Imovel $Imovel);
        public function destroy($id);

    }