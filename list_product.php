<?php
require 'connect.php';
//session_destroy();
$req = $dbh->prepare('SELECT * FROM products');
$req->execute();
$res = $req->fetchAll(); // Contient tous mes produits
if (!empty($_POST)) {
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = [];
    }
    array_push($_SESSION['panier'], $_POST['id']);
}

foreach ($res as $item) {
    echo '<img height="20" src="upload/' . $item['picture'] . '" >';
    echo '<form method="POST">';
  
    echo '<button type="submit"> Ajouter au panier </button>';
    echo '</form>';
}