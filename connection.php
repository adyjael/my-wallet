<?php

class Connection
{

    private  static $host = "localhost";
    private static $user = "root";
    private static $pass = "";
    private static $bdname = "app_bank";


    public static function connect(){

        try {
            $conn = new PDO('mysql:host='. self::$host.';dbname='. self::$bdname, self::$user, self::$pass);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
              echo 'ERROR: ' . $e->getMessage();
          }

          return $conn;
    }

}
