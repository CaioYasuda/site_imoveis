<?php 
    require_once("templates/header.php");
    require_once("dao/imovelDAO.php");

    //DAO dos imoveis
    $imovelDAO = new imovelDAO($conn, $BASE_URL);

    $lastestImovel = $imovelDAO->getLastestImovel();

    $apImoveis = $imovelDAO->getImovelByCategory("Apartamento");

    $houseImoveis = $imovelDAO->getImovelByCategory("Casa");

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Novos imóveis</h2>
        <P class="section-description">Veja os ultimos imóveis adicionados no site</P>
        <div class="movies-container">
            <?php foreach($lastestImovel as $imovel): ?>
                <?php require("templates/imovel_card.php"); ?>
            <?php endforeach; ?> 
            <?php if(count($lastestImovel) === 0): ?>
                <p class="empty-list">Ainda não há imóveis cadastrados!</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title">Apartamentos</h2>
        <P class="section-description">Veja os melhores apartamentos</P>
        <div class="movies-container">
            <?php foreach($apImoveis as $imovel): ?>
                <?php require("templates/imovel_card.php"); ?>
            <?php endforeach; ?> 
            <?php if(count($apImoveis) === 0): ?>
                <p class="empty-list">Ainda não há apartamentos cadastrados!</p>
            <?php endif; ?>
        </div>

        <h2 class="section-title">Casas</h2>
        <P class="section-description">Veja as melhores casas</P>
        <div class="movies-container">
            <?php foreach($houseImoveis as $imovel): ?>
                <?php require("templates/imovel_card.php"); ?>
            <?php endforeach; ?> 
            <?php if(count($houseImoveis) === 0): ?>
                <p class="empty-list">Ainda não há casas cadastradas!</p>
            <?php endif; ?>
        </div>
    </div>



<?php 
    require_once("templates/footer.php");
?>