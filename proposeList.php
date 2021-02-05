<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("dao/imovelDAO.php");
    require_once("dao/proposalDAO.php");
    require_once("models/user.php");

    //Resgatar dados do usuario
    $userData = $userDAO->verifyToken(true);

    $proposes = $proposalDAO->proposalByUser();

?>

    <div class="container-list">
        <h1 id="main-title">Minhas propostas</h1>
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
                        <th scope="col">Imóvel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($proposes as $propose): ?>
                        <tr>
                            <?php
                                $namecomplet = ($propose["name_buyer"] . " " . $propose["lastname_buyer"]);
                            ?>
                            <td scope="row" class="col-id"><?=$namecomplet?></td>
                            <td scope="row"><?=$propose["value"]?></td>
                            <td scope="row"><?=$propose["cpf_buyer"]?></td>
                            <td scope="row"><?=$propose["phone_buyer"]?></td>
                            <td scope="row"><?=$propose["email_buyer"]?></td>
                            <td scope="row"><?=$propose["observations"]?></td>
                            <td scope="row">link do imovel</td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        <?php else: ?>
            <p id="empty-list-text">Ainda não há contatos na sua agenda, <a href="<?=$BASE_URL ?>Create.php">clique aqui para adicionar</a>.</p>
        <?php endif; ?>
    </div>



<?php
    require_once("templates/footer.php");
?>