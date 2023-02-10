<?php
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("display_errors", 1);

require_once("config.php");


$showForm = new PhpFormBuilder();
$showForm->add_input("Username: ", array(
    "type" => "text",
    "required" => true,
), "username");
$showForm->add_input("Password: ", array(
    "type" => "password",
    "required" => true,
), "password");
$showForm->add_input("Submit", array(
    "type" => "submit",
    "value" => "Login",
), "submit");

$showForm->build_form();

if (isset($_POST["submit"])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);                           #like: helps with casing, add hashing and verifying later on.
    $q = $db->prepare("SELECT username, password from user where username like :username and password=:password");
    $q->bindValue(":username", $username, SQLITE3_TEXT);
    $q->bindValue(":password", $password, SQLITE3_TEXT);
    $results = $q->execute();

    $rows = [];


    while($user = $results->fetchArray(SQLITE3_ASSOC)) {
        echo $user["username"];
        $rows [] = $user;
    }


    if (count($rows) === 0) {
        echo "User does not exist!";
    }
    else {
        
        header('Location: geo.php');
    }

}













?>