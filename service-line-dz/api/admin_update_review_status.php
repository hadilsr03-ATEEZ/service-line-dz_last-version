<?php

header("Content-Type: application/json");

include "connect.php";

$data =
json_decode(
file_get_contents("php://input"),
true
);

$idAvis =
intval($data["idAvis"]);

$status =
$data["status"];

$stmt =
$conn->prepare(

"UPDATE avis

SET status = ?

WHERE idAvis = ?"

);

$stmt->bind_param(
"si",
$status,
$idAvis
);

echo json_encode([

"success" =>

$stmt->execute()

]);

$conn->close();

?>