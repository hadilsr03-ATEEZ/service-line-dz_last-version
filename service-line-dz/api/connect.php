<?php
// NEVER close PHP tag

$host = "sql300.infinityfree.com";
$dbname = "if0_42155526_serviceline_dz";
$username = "if0_42155526";
$password = "mDCZp6zNOpDcbq";

$conn = mysqli_init();
mysqli_real_connect($conn, $host, $username, $password, $dbname);

mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    die("DB connection failed");
}