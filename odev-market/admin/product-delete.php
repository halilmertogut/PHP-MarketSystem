<?php
require_once('./header.php');
if (!isset($_SESSION['admin'])) {
    header('Location: ./login.php');
    exit;
}
$id = $_GET['id'];
$control = $conn->prepare('DELETE FROM product WHERE id = ?');
$control->execute([$id]);

header('Location: product-list.php');