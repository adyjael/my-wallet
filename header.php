
<?php session_start() ?>


  




    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/card.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    

<?php if (isset($_SESSION["userEmail"]) && !empty($_SESSION["userEmail"])) { ?>

        
<nav class="cabecalho">
        <a class="cabecalho-brand" href="#">
            <div class="icon-container">
                <img class="icon hexagon" />
            </div>
            <span class="name">My Wallet</span>
        </a>
        <ul class="cabecalho-nav">
            <li>
                <a href="./dashboard.php" class="active"><img class="icon home" /><span>Dashboard</span></a>
            </li>
            <li>
                <a href="./depositos.php"><img class="icon statistics" /><span>Entradas</span></a>
            </li>
            <li>
                <a href="./levantamentos.php"><img class="icon file" /><span>Saidas</span></a>
            </li>
            <li>
                <a href="./trasferido.php"><img class="icon mail" /><span>Transfers</span></a>
            </li>
            <li>
                <a href="./recebidos.php"><img class="icon mail" /><span>Recebidas</span></a>
            </li>
            <li>
                <a href="./logout.php"><img class="icon user" /><span>Sair</span></a>
            </li>
         
        </ul>
 
    </nav>


<?php } else{ ?>

    
<nav class="cabecalho">
        <a class="cabecalho-brand" href="#">
            <div class="icon-container">
                <img class="icon hexagon" />
            </div>
            <span class="name">Financial CRM</span>
        </a>
        <ul class="cabecalho-nav">
            <li>
                <a href="./index.php" class="active"><img class="icon home" /><span>Login</span></a>
            </li>
        </ul>
 
    </nav>

    <?php }?>
