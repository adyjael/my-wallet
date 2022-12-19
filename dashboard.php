<?php
include_once("header.php");
include_once("./connection.php");
if (!isset($_SESSION["userEmail"])) {
    header("Location: index.php");
}
setlocale(LC_MONETARY, 'en_US');
// Buscar nome , id do usuario que está logado
$user = Connection::connect()->prepare("SELECT id,username FROM users WHERE email = ? limit 1");
$user->execute(array($_SESSION["userEmail"]));
$result = $user->fetch(PDO::FETCH_ASSOC);
$nome = $result["username"];
$id = $result["id"];
$_SESSION["userId"] = $id;

// Buscar  saldo total do usuario;
$saldo = Connection::connect()->prepare("SELECT * From amount_total WHERE id_user = ?");
$saldo->execute(array($id));
$saldo = $saldo->fetchAll(PDO::FETCH_ASSOC)[0];
$saldoTotal = $saldo["saldo"];
$saldo_retirado = $saldo["saldo_retirado"];
$saldo_enviado = $saldo["saldo_enviado"];
$saldo_recebido = $saldo["saldo_recebido"];
$saldo_depositado = $saldo["saldo_depositado"];





?>


<main>

    <h1>My Wallet</h1>
    <div class="actions">
        <button data-bs-toggle="modal" data-bs-target="#depositar" class="btn-actions"> <i class="fa-solid fa-money-bill"></i> Adicionar</button>
        <button data-bs-toggle="modal" data-bs-target="#retirar" class="btn-actions"><i class="fa-solid fa-money-bill"></i> Retirar</button>
        <button data-bs-toggle="modal" data-bs-target="#enviar" class="btn-actions"><i class="fa-solid fa-money-bill-transfer"></i> Transferir</button>
        <button id="btn-resetar" reset="<?= $id ?>" class="btn-actions">Zerar tudo</button>
    </div>
    <div class="charts-wrapper">

        <section role="chart" class="exchange-rates">
            <h3 class="title">Bem vindo(a) <span style="font-size: 20px;">@<?= strtolower($nome) ?></span></h3>

            <div class="row1-container" style="margin-top: 20px;">
                <div class="box box-down cyan">
                    <h2>Saldo</h2>
                    <p class="greem-valor"> <i class="fa-solid fa-caret-up"></i> 
                    $<?= number_format($saldoTotal, 2, ",", ".") ?></p>
                </div>
                <div class="box box-down blue">
                    <h2>Entradas</h2>
                    <p class="blue-valor"><i class="fa-solid fa-caret-up"></i> $<?= number_format($saldo_depositado, 2, ",", ".") ?></p>
                </div>
                <div class="box box-down red">
                    <h2>Saidas</h2>
                    <p class="red-valor"><i class="fa-solid fa-caret-down"></i> $<?= number_format($saldo_retirado, 2, ",", ".") ?></p>
                </div>

                <div class="box  orange">
                    <h2>Transfers</h2>
                    <p class="red-valor"><i class="fa-solid fa-caret-down"></i> $<?= number_format($saldo_enviado, 2, ",", ".") ?></p>
                </div>
                <div class="box red">
   
                    <h2>Recebidas</h2>
                    <p class="greem-valor"><i class="fa-solid fa-caret-up"></i> $<?= number_format($saldo_recebido, 2, ",", ".") ?></p>
                </div>
            </div>




         
        </section>
        <section role="charts" class="last-costs">
            <h3 class="title">Atividades</h3>
            <div id="chart"></div>

        </section>
    </div>
</main>










<!-- MODAIS DEPOSITAR -->

<!-- Modal -->
<div class="modal fade" id="depositar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Depositar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-deposit">

                    <div>
                        <input type="hidden" value="<?= $id ?>" id="id_user">
                        <label for="valor-depositar">Valor</label>
                        <input type="text" id="valor-depositar" placeholder="Insira o valor que deseja depositar" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-deposit" class="btn btn-primary">Depositar</button>
            </div>
        </div>
    </div>
</div>




<!-- MODAIS retirar -->

<!-- Modal -->
<div class="modal fade" id="retirar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Retirar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-retirar">
                    <div>
                        <label for="Motivo">Finalidade</label>
                        <input type="text" id="motivo-retirar" class="form-control" placeholder="Opcional">
                    </div>
                    <div>
                        <input type="hidden" value="<?= $id ?>" id="id_user-retirar">
                        <label for="valor-retirar">Valor</label>
                        <input type="text" id="valor-retirar" placeholder="Insira o valor que deseja retirar" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-retirar" class="btn btn-primary">Retirar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAIS retirar -->

<!-- Modal -->
<div class="modal fade" id="enviar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviar dinheiro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $users = Connection::connect()->prepare("SELECT * FROM users WHERE id != ?");
                $users->execute(array($id));
                $users = $users->fetchAll(PDO::FETCH_ASSOC);



                ?>
                <form class="form-enviar">
                    <div>
                        <select class="form-control" id="user-receber">
                            <option value="0">Selecione o usuario que irá receber</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user["id"] ?>">@<?= $user["username"] ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="Motivo">Mesgasem</label>
                        <input type="text" id="motivo-enviar" class="form-control" placeholder="Opcional">
                    </div>
                    <div>
                        <input type="hidden" value="<?= $id ?>" id="id_user-enviar">
                        <label for="valor-retirar">Valor</label>
                        <input type="text" id="valor-enviar" placeholder="Insira o valor que deseja tranferir" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-enviar" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</div>




<?php include_once("./footer.php")  ?>
<script>

                                
    var id_user = ($("#id_user").val());


$.ajax({
    url: "Bank.php",
    dateType: "JSON",
    type: "POST",
    data: {
        type: "grafico",
        id_user: id_user,
    },
    success: function(response){
        response = JSON.parse(response);
        var dados = response[0];

        var options = {
            series: [{
            name: 'Despesas',
            data: [Number(dados.saldo_retirado) + Number(dados.saldo_enviado)]
          }, {
            name: 'Receitas',
            data: [dados.saldo] 
          }],
            chart: {
            type: 'bar',
            height: 350
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '55%',
              endingShape: 'rounded'
            },
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
          },
          xaxis: {
            categories: ['Total'],
          },
          yaxis: {
            title: {
              text: '$ (Dinheiro)'
            }
          },
          fill: {
            opacity: 1
          },
          tooltip: {
            y: {
              formatter: function (val) {
                return "$ " + val
              }
            }
          }
          };
    
          var chart = new ApexCharts(document.querySelector("#chart"), options);
          chart.render();
        

    },
    error: function(error){
        console.log(error);
    }
})



</script>