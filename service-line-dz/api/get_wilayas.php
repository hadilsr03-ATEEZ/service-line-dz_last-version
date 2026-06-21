<?php

error_reporting(E_ALL);

include "connect.php";

$sql = "SELECT idWilaya, nomWilaya FROM wilaya";
$result = mysqli_query($conn, $sql);

$wilayas = [];

while ($row = mysqli_fetch_assoc($result)) {
    $wilayas[] = $row;
}

// DO NOT send header yet — test raw output first
echo json_encode($wilayas, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);