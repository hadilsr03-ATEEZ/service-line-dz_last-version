<?php

header("Content-Type: application/json");

include "connect.php";

$userId =
    $_GET["userId"] ?? null;

if (!$userId) {

    echo json_encode([
        "error" => "User ID missing"
    ]);

    exit;
}

$stmt = $conn->prepare("
SELECT idClient
FROM client
WHERE idUtilisateur = ?
");

$stmt->bind_param(
    "i",
    $userId
);

$stmt->execute();

$result =
    $stmt->get_result();

$client =
    $result->fetch_assoc();

echo json_encode([
    "idClient" =>
        $client["idClient"] ?? null
]);

$conn->close();