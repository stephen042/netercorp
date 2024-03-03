<?php

define("WEB_TITLE","Golden Stone"); // Bank Name
define("WEB_URL","https://goldenstonefinance.online/account"); // No Ending splash
define("WEB_EMAIL", "support@goldenstonefinance.online"); // Your Website Email

$web_url = WEB_URL;

function dbConnect(){
    $servername = "localhost";
    $username = "root"; //DATABASE USERNAME
    $password = ""; //DATABASE PASSWORD
    $database = "netercorp"; //DATABASE NAME
    $port = "3308"; //DATABASE port NB default is 3300
    $dns = "mysql:host=$servername;port=$port;dbname=$database";

    try {
        $conn = new PDO($dns, $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
//return dbConnect();

function inputValidation($value): string
{
    return trim(htmlspecialchars(htmlentities($value)));
}