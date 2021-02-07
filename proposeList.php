<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/imovelDAO.php");
    require_once("dao/proposalDAO.php");
    require_once("models/user.php");

    $ProposalDAO = new ProposalDAO($conn, $BASE_URL);

    //Resgatar dados do usuario
    $userData = $userDAO->verifyToken(true);

    // Pegar id do imovel
    $id = filter_input(INPUT_GET, "id");

    //Consulta dos propostas
    $proposes = $ProposalDAO->proposalByImovel($id);

    $propertie = $ProposalDAO->getPropertirById($id);

?>

    <div class="container-list">
        <h1 class="titpropose">Propostas para <?=$propertie->title?></h1>
        <?php if (count($proposes) > 0): ?>
            <table class="table" id="contacts-table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($proposes as $propose): ?>
                        <tr>
                            <?php
                                $namecomplet = ($propose["name_buyer"] . " " . $propose["lastname_buyer"]);
                            ?>
                            <td scope="row" class="col-id"><?=$namecomplet?></td>
                            <td scope="row">R$<?=$propose["value"]?></td>
                            <td scope="row"><?=$propose["cpf_buyer"]?></td>
                            <td scope="row"><?=$propose["phone_buyer"]?></td>
                            <td scope="row"><?=$propose["email_buyer"]?></td>
                            <td scope="row"><?=$propose["observations"]?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        <?php else: ?>
            <p id="empty-list-text">Ainda não há propostas para o seu imóvel</p>
        <?php endif; ?>
    </div>



<?php
    require_once("templates/footer.php");
?>