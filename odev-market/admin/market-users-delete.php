<?php
require_once('./header.php');
if (!isset($_SESSION['admin'])) {
    header('Location: ./login.php');
    exit;
}
$id = $_GET['id'];
$control = $conn->prepare('DELETE FROM market_users WHERE id = ?');
$control->execute([$id]);

header('Location: market-users-list.php');