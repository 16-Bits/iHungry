<?php
$user = 'root';
$password = 'root';
$db = 'restaurantdb';
$host = 'localhost';

$currOrderID = time();
$_SESSION['orderID'] = $currOrderID;

try {
    $connStr = 'mysql:host=localhost;dbname=restaurantdb';
    $pdo = new PDO($connStr, $user, $password);
    //echo ("<h3>DEBUG: DB loaded<h3>");
} catch (PDOException $e) {
    die($e->getMessage());
}
$deleteOrderQuery = 'DELETE FROM orders WHERE OrderID = ' . $_GET['OrderID'];
$pdo->query($deleteOrderQuery);
header("Location: incomingOrders.php");
?>