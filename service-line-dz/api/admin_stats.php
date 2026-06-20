<?php

header("Content-Type: application/json");

include "connect.php";


$users =
$conn->query("
SELECT COUNT(*) as total
FROM utilisateur
")
->fetch_assoc();


$providers =
$conn->query("
SELECT COUNT(*) as total
FROM artisan
")
->fetch_assoc();


$pending =
$conn->query("
SELECT COUNT(*) as total
FROM artisan
WHERE statut='EN_ATTENTE'
")
->fetch_assoc();


$services =
$conn->query("
SELECT COUNT(*) as total
FROM service
")
->fetch_assoc();


echo json_encode([

"users"=>$users["total"],

"providers"=>$providers["total"],

"pending"=>$pending["total"],

"services"=>$services["total"]

]);


$conn->close();

?>