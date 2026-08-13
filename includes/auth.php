<?php
require_once __DIR__ . "/flash.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: /coursehub/login.php");
    exit;
}
