<?php
include_once("header.php");
include_once("./connection.php");
if (!isset($_SESSION["userEmail"])) {
    header("Location: index.php");
}
$userId = $_SESSION["userId"];

// Buscar depositos do usuario que está logado
$recebidos = Connection::connect()->prepare("SELECT * FROM transfer_money WHERE to_userid = ?");
$recebidos->execute(array($userId));
$recebidos = $recebidos->fetchAll(PDO::FETCH_ASSOC);

?>






<main>

    <h1>Recebidos</h1>


    <div class="charts-wrapper">

        <section role="chart" class="exchange-rates">

            <?php if (count($recebidos) > 0) : ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Valor Recebido</th>
                            <th>De</th>
                            <th>Mensagem</th>
                            <th scope="col">Data</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php foreach ($recebidos as $recebido) :  ?>
                            <?php 
                                
                                $user = Connection::connect()->prepare("SELECT id,username FROM users WHERE id = ? limit 1");
                                $user->execute(array($recebido["from_userid"]));
                                $result = $user->fetch(PDO::FETCH_ASSOC);
                                $nome = $result["username"];
                                ?>
                            <tr>
                                <td scope="row"><?= $recebido["id"] ?></td>
                                <td>$<?= $recebido["amount"] ?></td>
                                <td>@<?= $nome ?></td>
                                <td><?= $recebido["description"] ?></td>
                                <td><?= date("d/m/Y",strtotime($recebido["date"])) ?></td>
                                <td><?= date("H:i",strtotime($recebido["date"])) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php else :  ?>

                <h4 class="text-center">Você ainda não recebeu nenhum dinheiro</h4>
            <?php endif  ?>




        </section>

    </div>
</main>










<?php include_once("./footer.php")  ?>