<?php
include("./connection.php");

class Bank
{

    private $conn;
    private $saldoTotal;
    private $saldoRetirado;
    private $saldoEnviado;
    private $saldoRecebido;
    private $saldoDepositado;


    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->deposit();
        $this->retirar();
        $this->enviar();
        $this->reset();
        $this->grafico();
        $this->graficoDeposito();
        $this->graficoRetirar();
        $this->graficoEnviar();
    }




    public function deposit()
    {

        if (isset($_POST) && $_POST["type"] == "deposit") {
            $valor = $_POST["valor"];
            $userId = $_POST["id_user"];
            $query = $this->conn->prepare("INSERT INTO deposit (amount,user_id,date) VALUES (?,?, NOW())");
            $query->execute(array($valor, $userId));

            if ($query == true) {
                $this->setSaldoDepositado($userId,$this->getSaldoDepositado($userId) + $valor);
                $this->setSaldoTotal($userId, $this->getSaldoTotal($userId) + $valor);
                echo json_encode(array("error" => false));
            } else {
                echo json_encode(array("error" => true, "msg" => "Erro ao depositar tnte novamente"));
            }
        }
    }

    public function retirar()
    {

        if (isset($_POST) && $_POST["type"] == "retirar") {
            $saldo_retirado = $_POST["valor"];
            $userId = $_POST["id_user"];
            $motivo = $_POST["motivo"];

            if ($saldo_retirado > $this->getSaldoTotal($userId)) {
                echo json_encode(array("error" => true, "msg" => "Não podes sacar esse valor porque o teu saldo é insuficiente"));
                return;
            }

            $query = $this->conn->prepare("INSERT INTO take_money (amount,user_id,motivo,date) VALUES (?,?,?, NOW())");
            $query->execute(array($saldo_retirado, $userId, $motivo));

            if ($query == true) {
                $this->setSaldoRetirado($userId, $this->getSaldoRetirado($userId) + $saldo_retirado);
                $this->setSaldoTotal($userId, $this->getSaldoTotal($userId) - $saldo_retirado);
                echo json_encode(array("error" => false));
            } else {
                echo json_encode(array("error" => true, "msg" => "Erro ao depositar tnte novamente"));
            }
        }
    }

    public function enviar()
    {


        if (isset($_POST) && $_POST["type"] == "enviar") {
            $saldo_a_enviar = $_POST["valor"];
            $userEnviar = $_POST["userEnviar"];
            $userReceber = $_POST["userReceber"];
            $motivo = $_POST["motivo"];
            if($this->getSaldoTotal($userEnviar) < $saldo_a_enviar){
                echo json_encode(array("error"=> true, "msg" => "Saldo insuficiente"));
                return;

            }
            $query = $this->conn->prepare("INSERT INTO transfer_money (amount,description,from_userid,to_userid,date) VALUES (?,?,?,?, NOW())");
            $query->execute(array($saldo_a_enviar, $motivo, $userEnviar, $userReceber));

            if ($query == true) {
                $this->setSaldoEnviado($userEnviar, $this->getSaldoEnviado($userEnviar) + $saldo_a_enviar);
                $this->setSaldoTotal($userEnviar, $this->getSaldoTotal($userEnviar) - $saldo_a_enviar);
                $this->setSaldoTotal($userReceber, $this->getSaldoTotal($userReceber) + $saldo_a_enviar);
                $this->setSaldoReceber($userReceber, $this->getSaldoRecebido($userReceber) + $saldo_a_enviar);
                echo json_encode(array("error" => false));
            }
        }
    }

    public function graficoDeposito(){
        if(isset($_POST) && $_POST["type"] == "grafico-deposit"){
            $userId = $_POST["id_user"];
            $query = $this->conn->prepare("SELECT * from deposit WHERE user_id = ? ORDER BY date DESC Limit 5  ");
            $query->execute(array($userId));
            $query = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($query);
            
        }
    }
    public function graficoRetirar(){
        if(isset($_POST) && $_POST["type"] == "grafico-retirar"){
            $userId = $_POST["id_user"];
            $query = $this->conn->prepare("SELECT * from take_money WHERE user_id = ? ORDER BY date DESC Limit 5  ");
            $query->execute(array($userId));
            $query = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($query);
            
        }
    }
    public function graficoEnviar(){
        if(isset($_POST) && $_POST["type"] == "grafico-enviar"){
            $userId = $_POST["id_user"];
            $query = $this->conn->prepare("SELECT * from transfer_money WHERE from_userid = ? ORDER BY date DESC Limit 3  ");
            $query->execute(array($userId));
            $query = $query->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($query);
            
        }
    }

    public function reset(){

        if(isset($_POST) && $_POST["type"] == "reset"){

            $userId = $_POST["id_user"];
            $this->setSaldoDepositado($userId,0);
            $this->setSaldoEnviado($userId,0);
            $this->setSaldoReceber($userId,0);
            $this->setSaldoTotal($userId,0);
            $this->setSaldoRetirado($userId,0);

            $queryD = $this->conn->prepare("DELETE FROM deposit WHERE user_id = ?");
            $queryD->execute(array($userId));
            $queryFrom = $this->conn->prepare("DELETE FROM transfer_money WHERE from_userid  = ?");
            $queryFrom->execute(array($userId));
            $querylEVA= $this->conn->prepare("DELETE FROM take_money WHERE user_id  = ?");
            $querylEVA->execute(array($userId));

            echo json_encode(array("error" => false));
            

        }



    }

    public function grafico(){
        if(isset($_POST) && $_POST["type"] == "grafico"){
            $userId = $_POST["id_user"];

            $query = $this->conn->prepare("SELECT * FROM amount_total WHERE id_user = ?");
            $query->execute(array($userId));
            $query = $query->fetch(PDO::FETCH_ASSOC);

            echo json_encode(array($query));
        }
    }




    public function setSaldoTotal(int $userId, $saldo)
    {

        $query = $this->conn->prepare("UPDATE amount_total SET saldo = ? WHERE id_user = ?");
        $query->execute(array($saldo, $userId));
    }

    public function setSaldoRetirado($userId, $saldo)
    {
        $query = $this->conn->prepare("UPDATE amount_total SET saldo_retirado = ? WHERE id_user = ?");
        $query->execute(array($saldo, $userId));
    }

    public function setSaldoEnviado($userEnviar, $saldo)
    {
        $query = $this->conn->prepare("UPDATE amount_total SET saldo_enviado = ? WHERE id_user = ?");
        $query->execute(array($saldo, $userEnviar));
    }

    public function setSaldoReceber($userReceber, $saldo)
    {
        $query = $this->conn->prepare("UPDATE amount_total SET saldo_recebido = ? WHERE id_user = ?");
        $query->execute(array($saldo, $userReceber));
    }
    public function setSaldoDepositado($userId,$saldo){
        $query = $this->conn->prepare("UPDATE amount_total SET saldo_depositado = ? WHERE id_user = ?");
        $query->execute(array($saldo, $userId));
    }





    public function getSaldoTotal($userId)
    {

        $query = $this->conn->prepare("SELECT saldo FROM amount_total WHERE id_user = ?");
        $query->execute(array($userId));
        $query = $query->fetch(PDO::FETCH_ASSOC);
        $saldo = $query["saldo"];
        return $this->saldoTotal = $saldo;
    }

    public function getSaldoRetirado($userId)
    {
        $query = $this->conn->prepare("SELECT saldo_retirado FROM amount_total WHERE id_user = ?");
        $query->execute(array($userId));
        $query = $query->fetch(PDO::FETCH_ASSOC);
        $saldo_retirado = $query["saldo_retirado"];
        return $this->saldoRetirado = $saldo_retirado;
    }
    public function getSaldoEnviado($userId)
    {
        $query = $this->conn->prepare("SELECT saldo_enviado FROM amount_total WHERE id_user = ?");
        $query->execute(array($userId));
        $query = $query->fetch(PDO::FETCH_ASSOC);
        $saldo_enviado = $query["saldo_enviado"];
        return $this->saldoEnviado = $saldo_enviado;
    }
    public function getSaldoRecebido($userId)
    {
        $query = $this->conn->prepare("SELECT saldo_recebido FROM amount_total WHERE id_user = ?");
        $query->execute(array($userId));
        $query = $query->fetch(PDO::FETCH_ASSOC);
        $saldo_recebido = $query["saldo_recebido"];
        return $this->saldoRecebido = $saldo_recebido;
    }
    public function getSaldoDepositado($userId)
    {
        $query = $this->conn->prepare("SELECT saldo_depositado FROM amount_total WHERE id_user = ?");
        $query->execute(array($userId));
        $query = $query->fetch(PDO::FETCH_ASSOC);
        $saldo_depositado = $query["saldo_depositado"];
        return $this->saldoDepositado = $saldo_depositado;
    }
}


$bank = new Bank(Connection::connect());
