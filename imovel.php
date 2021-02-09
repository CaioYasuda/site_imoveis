<?php

    require_once("templates/header.php");
    require_once("models/imoveis.php");
    require_once("dao/imovelDAO.php");
    require_once("dao/ProposalDAO.php");

    // Pegar id do imovel
    $id = filter_input(INPUT_GET, "id");

    $imovel;

    $imovelDAO = new ImovelDAO($conn, $BASE_URL);
    $ProposalDAO = new ProposalDAO($conn, $BASE_URL);

    if (empty($id)) {

        $message->setMessage("O imóvel não foi encontrado", "error", "index.php");

    } else {

        $imovel = $imovelDAO->findById($id);

        //Verifica se o imovel existe
        if (!$imovel) {

            $message->setMessage("O imóvel2 não foi encontrado", "error", "index.php");

        }

    }

    //Checa se o imovel tem imagem
    if ($imovel->image == "") {
        $imovel->image = "movie_cover.jpg";
    }

    //Checa se o imovel é do usuario
    $userOwnsPropertie = false;

    if (!empty($userData)) {

        if($userData->id === $imovel->users_id) {
            $userOwnsPropertie = true;
        }

        // Resgata as propostar já feitas
        $alreadyProposed = $ProposalDAO->hasAlreadyProposed($id, $userData->id);

    }

    // Resgata as propostas do imovel
    $imovelProposal = $ProposalDAO->getPropertieProposal($id);

?>

    <div id="main-container" class="container-fluid">
        <h1 class="page-title-imovel"><?= $imovel->title?></h1>
        <p class="movie-details">
            <span>Metragem: <?= $imovel->measure?>m²</span>
            <span class="pipe"></span>
            <span><?= $imovel->category?></span>
            <span class="pipe"></span>
            <span>Rua: <?= $imovel->address ?></span>
            <span class="pipe"></span>
            <span>Cidade: <?= $imovel->city ?></span>
        </p>
        <div class="row">
            <div class="offset-md-1 col-md-5 movie-container">
                <iframe src="<?= $imovel->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <div class="movie-image-container" style="background-image: url('<?=$BASE_URL ?>img/imoveis/<?=$imovel->image ?>')"></div>
            </div>
            <div class="col-md-5 description-propertie">
                <p><?= $imovel->description ?></p>
            </div> 
            <div class="offset-md-1 col-md-10" id="reviews-container">
                <!-- Verifica se habilita a review para o usuario ou não -->
                <?php if (!empty($userData) && !$userOwnsPropertie && !$alreadyProposed): ?>
                <div class="col-md-12" id="review-form-container">
                    <h4 class="enviepropose">Envie sua proposta:</h4>
                    <form action="<?= $BASE_URL?>propose_process.php" id="propose-form" class="propose-form" method="POST">
                        <input type="hidden" name="type" value="create">
                        <input type="hidden" name="properties_id" value="<?= $imovel->id?>">
                        <div class="form-group">
                            <label for="name_buyer">Nome: </label>
                            <input type="text" class="form-control" id="name_buyer" name="name_buyer" placeholder="Digite seu nome">
                            <label for="lastname_buyer" class="propose">Sobrenome: </label>
                            <input type="text" class="form-control" id="lastname_buyer" name="lastname_buyer" placeholder="Digite seu sobrenome">
                            <label for="value" class="propose">Valor: </label>
                            <input type="text" class="form-control" id="value" name="value" placeholder="Digite o valor da proposta">
                            <label for="cpf_buyer" class="propose">CPF: </label>
                            <input type="text" class="form-control" id="cpf_buyer" name="cpf_buyer" placeholder="Digite seu CPF">
                            <label for="phone_buyer" class="propose">Telefone: </label>
                            <input type="phone" class="form-control" id="phone_buyer" name="phone_buyer" placeholder="Digite seu telefone">
                            <label for="email_buter" class="propose">E-mail: </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="form-group">
                            <label for="observations">Observações: </label>
                            <textarea name="observations" id="observations" rows="3" class="form-control" placeholder="Alguma observação?"></textarea>
                        </div>
                        <input type="submit" class="btn card-btn" value="Enviar Proposta">
                    </form>
                </div>
                <?php else: ?> 
                    <div class="msg-container">
                    <h6 class="proposed-msg">Você já enviou uma proposta e a mesma se encontra em analise</h6>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>




<?php
    require_once("templates/footer.php");
?>