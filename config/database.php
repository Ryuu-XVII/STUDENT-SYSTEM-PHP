<?php

// Local development connection details.
// For production, replace these with getenv("DB_HOST") etc. and never commit real credentials.
$host = "localhost";
$username = "root";
$password = "";
$database = "coursehub_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");
