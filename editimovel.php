<?php 

    require_once("templates/header.php");
    require_once("models/user.php");
    require_once("dao/imovelDAO.php");
    require_once("dao/UserDAO.php");

    $user = new User();

    $userDAO = new UserDAO($conn, $BASE_URL); 

    $userData = $userDAO->verifyToken(true);

    $imovelDAO = new ImovelDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    if (empty($id)) {

        $message->setMessage("O imóvel não foi encontrado", "error", "index.php");
    
    } else {

        $imovel = $imovelDAO->findById($id);

        //Verifica se o imóvel existe
        if (!$imovel) {

            $message->setMessage("O imóvel não foi encontrado", "error", "index.php");

        }

    }

    // Checa a imagem
    if ($imovel->image == "") {
        $imovel->image = "movie_cover.jpg";
    }

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1 class="page-title"><?= $imovel->title?></h1>
                    <p class="page-description-edit">Altere os dados do imóvel no formulário abaixo:</p>
                    <form id="edit-movie-form" action="<?=$BASE_URL?>imovel_process.php" method="POST" ectype="multipart/form-data">
                        <input type="hidden" name="type" value="update">
                        <input type="hidden" name="id" value="<?= $imovel->id?>">
                        <div class="form-group">
                            <label for="title">Título:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu anuncio" value="<?=$imovel->title?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Endereço:</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Digite o endereço do imóvel" value="<?=$imovel->address?>">
                        </div>
                        <div class="form-group">
                            <label for="city">Cidade:</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Digite a cidade do anuncio" value="<?=$imovel->city?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Imagem:</label>
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <label for="measure">Metragem:</label>
                            <input type="text" class="form-control" id="measure" name="measure" placeholder="Digite a metragem do imóvel" value="<?=$imovel->measure?>">
                        </div>
                        <div class="form-group">
                            <label for="category">Categoria:</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Selecione</option>
                                <option value="Ação" <?=$imovel->category === "Apartamento" ? "selected" : "" ?>>Apartamento</option>
                                <option value="Drama" <?=$imovel->category === "Casa" ? "selected" : "" ?>>Casa</option>
                                <option value="Comedia" <?=$imovel->category === "Casa (cond. fechado)" ? "selected" : "" ?>>Casa (cond. fechado)</option>
                                <option value="Fantasia" <?=$imovel->category === "Casa (fundos)" ? "selected" : "" ?>>Casa (fundos)</option>
                                <option value="Fantasia/Ficção" <?=$imovel->category === "Duplex" ? "selected" : "" ?>>Duplex</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trailer">Video do imóvel:</label>
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?=$imovel->trailer?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição:</label>
                            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o imóvel"><?=$imovel->description?></textarea>
                        </div>
                        <input type="submit" class="btn card-btn" value="Editar Filme">
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="movie-image-container" style="background-image: url('<?= $BASE_URL?>img/imoveis/<?=$imovel->image?>')"></div>
                </div>
            </div>
        </div>
    </div>


<?php
    require_once("templates/footer.php");
?>