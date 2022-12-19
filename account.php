<?php


require("connection.php");
session_start();

class Account
{


    public function login()
    {
        if (isset($_POST) && $_POST["type"] == "login") {
            $email = htmlspecialchars($_POST["email"]);
            $password = ($_POST["password"]);

            $conn = Connection::connect();

            $query = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $query->execute(array($email));
            $result = $query->fetchAll(PDO::FETCH_ASSOC)[0];

            if ($result == false) {
                echo json_encode(array("error" => true, "msg" => "Este email ainda não esta cadastrado"));
                return;
            }
            $pass = $result["password"];

            if (password_verify($password, $pass)) {
                $_SESSION["userEmail"] = $result["email"];
                
                echo json_encode(array("error" => false, "msg" => "Passord coreta"));
            }else {
                echo json_encode(array("error" => true, "msg" => "Password invalida"));
                return;
            }
           
        }
    }

    public function cadastro()
    {
        if (isset($_POST) && $_POST["type"] == "cadastro") {

            $username = htmlspecialchars($_POST["username"]);
            $email = htmlspecialchars($_POST["email"]);
            $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);

            $conn = Connection::connect();

            $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $query->execute(array($email));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                echo json_encode(array("error" => true, "msg" => "Este email ja existe"));
                return;
            }

            $query = $conn->prepare("INSERT INTO users (username,email,password,created_at) VALUES (?,?,?, NOW())");

            $query->execute(array($username, $email, $password));

            if ($query) {
                $_SESSION["userEmail"] = $email;
                $query = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $query->execute(array($email));
                $id = $query->fetch(PDO::FETCH_ASSOC);
                $id = $id["id"];

                $insertSaldo = $conn->prepare("INSERT INTO amount_total (id_user,saldo_retirado,saldo_recebido,saldo_enviado,saldo) VALUES (?,?,?,?,?)");
                $insertSaldo->execute(array($id,0,0,0,0));

                echo json_encode(array("error" => false));
            } else {
                json_encode(array("error" => true, "msg" => "Erro ao cadatrar"));
            }
        }
    }
}



$user = new Account;
$user->cadastro();
$user->login();
