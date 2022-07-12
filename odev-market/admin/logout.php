<?php
require_once('./header.php');

session_destroy();
header('Location: login.php');