<?php

header("Content-Type: application/json");

require_once "connect.php";

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->userId)) {

    echo json_encode([
        "error" => "User ID missing"
    ]);

    exit;
}

$userId = (int)$data->userId;

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM utilisateur
     WHERE idUtilisateur = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $userId
);

mysqli_stmt_execute($stmt);

echo json_encode([
    "success" => true
]);

mysqli_close($conn);