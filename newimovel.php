<?php
    require_once("templates/header.php");
    require_once("models/user.php");
    require_once("dao/UserDAO.php");

    $user = new User();

    $userDAO = new UserDAO($conn, $BASE_URL);       

    $userData = $userDAO->verifyToken(true);
?>
    
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar Imóvel</h1>
            <p class="page-description">Adicione seu imóvel</p>
            <form action="<?= $BASE_URL?>imovel_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do imóvel">
                </div>
                <div class="form-group">
                    <label for="address">Endereço:</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Digite o endereço do imóvel">
                </div>
                <div class="form-group">
                    <label for="city">Cidade:</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Digite a cidade do imóvel">
                </div>
                <div class="form-group">
                    <input type="checkbox" id="Piscina" name="Piscina" value="Piscina">
                    <label for="Piscina"> Piscina</label><br>
                    <input type="checkbox" id="Estacionamento" name="Estacionamento" value="Estacionamento">
                    <label for="Estacionamento"> Estacionamento Coberto</label><br>
                    <input type="checkbox" id="Portaria" name="Portaria" value="Bike">
                    <label for="Portaria"> Portaria 24h</label><br>
                </div>
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <!--<div class="form-group">
                    <label for="image_2">Imagem 2:</label>
                    <input type="file" class="form-control-file" name="image_2" id="image_2">
                </div>
                <div class="form-group">
                    <label for="image_3">Imagem 3:</label>
                    <input type="file" class="form-control-file" name="image_3" id="image_3">
                </div>-->
                <div class="form-group">
                    <label for="length">Metragem:</label>
                    <input type="text" class="form-control" id="measure" name="measure" placeholder="Digite a metragem do imóvel">
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Apartamento">Apartamento</option>
                        <option value="Casa">Casa</option>
                        <option value="Casa (cond. fechado)">Casa (cond. fechado)</option>
                        <option value="Casa (fundos)">Casa (fundos)</option>
                        <option value="Duplex">Duplex</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Video do imóvel:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do video do imóvel">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o imóvel"></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar imóvel">
            </form>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>