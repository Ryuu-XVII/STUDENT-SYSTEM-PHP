<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function flash_set($type, $message) {
    $_SESSION["flash"] = ["type" => $type, "message" => $message];
}

function flash_get() {
    if (!empty($_SESSION["flash"])) {
        $flash = $_SESSION["flash"];
        unset($_SESSION["flash"]);
        return $flash;
    }
    return null;
}
