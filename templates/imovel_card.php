<?php

    if (empty($imovel->image)) {
        $imovel->image = "movie_cover.jpg";
    }

?>

<div class="card movie-card">
    <div class="card-img-top" style="background-image: url('<?=$BASE_URL ?>img/imoveis/<?=$imovel->image ?>')"></div>
    <div class="card-body">
        <h4 class="imovel-category"><?=$imovel->category?></h4>
        <h6 class="imovel-category2">
            <?php if ($imovel->rooms) {
                echo $imovel->rooms . " Dormitórios";
            } else {
                echo "Dormitórios: N/I";
            };?>
        </h6>
        <h6 class="imovel-category2">
            <?php if ($imovel->wc) {
                echo $imovel->wc . " toaletes";
            } else {
                echo "Toaletes: N/I";
            };?>
        </h6>
        <h6 class="imovel-category2">
            <?php if ($imovel->value) {
                echo "R$" . $imovel->value;
            } else {
                echo "R$ N/I";
            };?>
        </h6>
        
        <a href="<?=$BASE_URL?>imovel.php?id=<?=$imovel->id?>" class="btn btn-primary rate-btn">Fazer proposta</a>
        <a href="<?=$BASE_URL?>imovel.php?id=<?=$imovel->id?>" class="btn btn-primary card-btn">Conhecer</a>
    </div>
</div>