<?php
session_start();
global $mysqli;
$mysqli = new mysqli("h5x.h.filess.io", "projects_realbetter", "ab1afdab23a24b01c0f2edf72b65e8008605e5e9", "projects_realbetter", "3307");
require_once './Clients.php';
$path = explode('/', $_SERVER['REQUEST_URI'])[2];
$pathArr = explode('/', $_SERVER['REQUEST_URI']);
$title = "";
$visible = "";
$content = "404";
$clientact = "";
$addact = "";
$visibleTitle = true;
echo $path;
if ($path == "_unlock"){
    $_SESSION['verefication'] = 3;
    header("Location: /nameGym/clients");
}
if(isset($_SESSION['verefication'])){
    if ($path == "clients" or $path == "" or $path == "index.php" or $path == "router.php") {
        $_SESSION['verefication'] = 3;
        $title = "Список клиентов";
        $clientact = "active animate-element";
        $addact = "off";
        $visible = "";
        $visibleTitle = true;
        $content = file_get_contents('./clients.html');
    }
    //$_SESSION['verefication'] = 1;
    if ($path == "getClients") {
        exit(Clients::getClients());
    } elseif ($path == "addClient" and $_SERVER['REQUEST_METHOD'] == "GET") {
        $_SESSION['verefication'] = 3;
        $title = "Добавление нового посетителя";
        $addact = "active animate-element";
        $clientact = "off";
        $visibleTitle = false;
        $visible = "d-none";
        $content = file_get_contents('./addClient.html');
    } elseif ($pathArr[2] == "delete") {
        exit(Clients::deleteClient($pathArr[3]));
    } elseif ($pathArr[2] == "editClient") {
        exit(Clients::editClient($pathArr[3]));
    } elseif ($path == "addClient" and $_SERVER['REQUEST_METHOD'] == "POST") {
        exit(Clients::addClient());
    }
}else{
    exit(file_get_contents('./lock.html'));
}
if ($path == "lock") {
    unset($_SESSION['verefication']);
    $title = "";
    $addact = "";
    $visible = "";
    exit(file_get_contents('./lock.html'));
}

require_once './template.php';
