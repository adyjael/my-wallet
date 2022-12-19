<?php
include_once("header.php");
include_once("./connection.php");
if (!isset($_SESSION["userEmail"])) {
    header("Location: index.php");
}
$userId = $_SESSION["userId"];
setlocale(LC_MONETARY, 'en_US');


// Buscar tranzações do usuario que está logado
$trasferidos = Connection::connect()->prepare("SELECT * FROM transfer_money WHERE from_userid = ?");
$trasferidos->execute(array($userId));
$trasferidos = $trasferidos->fetchAll(PDO::FETCH_ASSOC);

?>






<main>

    <h1>Transfers</h1>


    <div class="charts-wrapper">

        <section role="chart" class="exchange-rates">

            <?php if (count($trasferidos) > 0) :


            ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Valor Trasnfrido</th>
                            <th>Para</th>
                            <th>Mensagem</th>
                            <th scope="col">Data</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trasferidos as $trasferido) :  ?>
                            <?php


                            $user = Connection::connect()->prepare("SELECT id,username FROM users WHERE id = ? limit 1");
                            $user->execute(array($trasferido["to_userid"]));
                            $result = $user->fetch(PDO::FETCH_ASSOC);
                            $nome = $result["username"];

                            ?>
                            <tr>
                                <td scope="row"><?= $trasferido["id"] ?></td>
                                <td>$<?= $trasferido["amount"] ?></td>
                                <td>@<?= $nome ?></td>
                                <td><?= $trasferido["description"] ?></td>
                                <td><?= date("d/m/Y", strtotime($trasferido["date"])) ?></td>
                                <td><?= date("H:i", strtotime($trasferido["date"])) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php else :  ?>

                <h4 class="text-center">Você ainda não fez nenhuma tranferencia</h4>
            <?php endif  ?>








            


        </section>
        <section role="chart" class="last-costs">
            <h3 class="title">Last Costs</h3>
            <div id="chart">

            </div>

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
                        <input type="hidden" value="<?= $userId ?>" id="id_user">
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





<?php include_once("./footer.php")  ?>

<script>
    var id_user = ($("#id_user").val());

    function formatarDate(dat) {
        let data = new Date(dat);
        let dataFormatada = (data.getFullYear() + "-" + ((data.getMonth() + 1)) + "-" + (data.getDate()));
        return dataFormatada;
    }

    $.ajax({
        url: "Bank.php",
        dateType: "JSON",
        type: "POST",
        data: {
            type: "grafico-enviar",
            id_user: id_user,
        },
        success: function(response) {
            response = JSON.parse(response);
            var dados = response;
            console.log(dados)

        if(dados.length < 3){
            $(".title").html("Para ver o grafico precisa de 3 Transferencias")
        }else {
            $(".title").html("Grafico de Tranferencias")

            var options = {
                series: [{
                    name: 'Valor tranferido',
                    data: [dados[0].amount,dados[1].amount,dados[2].amount]
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return "$" +val ;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: [dados[0].date, dados[1].date,dados[2].date],
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: 'red',
                                colorTo: 'red',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function(val) {
                            return "$" +val;
                        }
                    }

                },
                title: {
                    text: 'Grafico de Tranferencias',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

        


            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();


        }
          


        



        },
        error: function(error) {
            console.log(error);
        }
    })
</script>