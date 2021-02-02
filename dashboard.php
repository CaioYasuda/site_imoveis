<?php 

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/imovelDAO.php");
    require_once("models/user.php");

    $user = new User();
    $userDAO = new UserDAO($conn, $BASE_URL);
    $imovelDAO = new imovelDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);

    $userImoveis = $imovelDAO->getImovelByUserId($userData->id);

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Dashboard</h2>
        <p class="section-description">Adicione ou atualize as informações dos imóveis anunciados</p>
        <div class="col-md-12" id="add-movie-container">
            <a href="<?=$BASE_URL?>newmovie.php" class="btn card-btn">
                <i class="fas fa-plus"></i> Adicionar imóvel
            </a>
        </div>
        <div class="col-md-12" id="movies-dashboard">
            <table class="table">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Títulos</th>
                    <th scope="col">Propostas</th>
                    <th scope="col" class="actions-column">Ações</th>
                </thead>
                <tbody>
                    <?php foreach($userImoveis as $imovel): ?>
                    <tr>
                        <td scope="row"><?= $imovel->id ?></td>
                        <td><a href="#" class="table-movie-title"><?= $imovel->title ?></a></td>
                        <td><i class="fas fa-star"></i>2 propostas</td>
                        <td class="actions-column">
                            <a href="#" class="edit-btn">
                                <i class="far fa-edit"></i> Editar
                            </a>
                            <form action="<?=$BASE_URL?>imovel_process.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="id" value="<?= $imovel->id ?>">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> 
        
    </div>    

<?php
    require_once("templates/footer.php");
?>
