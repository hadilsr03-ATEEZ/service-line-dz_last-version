<?php

header("Content-Type: application/json");

include "connect.php";


$data =
json_decode(
file_get_contents("php://input"),
true
);



$stmt =
$conn->prepare(

"UPDATE artisan

SET statut=?

WHERE idArtisan=?"


);



$stmt->bind_param(

"si",

$data["status"],

$data["idArtisan"]

);



echo json_encode([

"success"=>$stmt->execute()

]);


?>