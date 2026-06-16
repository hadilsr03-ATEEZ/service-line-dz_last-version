<?php

header("Content-Type: application/json");

include "connect.php";

$data =
    json_decode(
        file_get_contents("php://input")
    );

if (
    !$data ||
    !isset(
        $data->userId,
        $data->reviewId
    )
) {

    echo json_encode([
        "error" => "Missing data"
    ]);

    exit;
}

$userId =
    (int)$data->userId;

$reviewId =
    (int)$data->reviewId;

/* Get Client */

$clientStmt =
    $conn->prepare("
    SELECT idClient
    FROM client
    WHERE idUtilisateur = ?
    LIMIT 1
");

$clientStmt->bind_param(
    "i",
    $userId
);

$clientStmt->execute();

$clientResult =
    $clientStmt->get_result();

if (
    $clientResult->num_rows === 0
) {

    echo json_encode([
        "error" => "Client not found"
    ]);

    exit;
}

$idClient =
    $clientResult
    ->fetch_assoc()["idClient"];

/* Check ownership */

$check =
    $conn->prepare("
    SELECT idAvis
    FROM avis
    WHERE idAvis = ?
    AND idClient = ?
");

$check->bind_param(
    "ii",
    $reviewId,
    $idClient
);

$check->execute();

if (
    $check
    ->get_result()
    ->num_rows === 0
) {

    echo json_encode([
        "error" => "Unauthorized"
    ]);

    exit;
}

/* Delete */

$delete =
    $conn->prepare("
    DELETE FROM avis
    WHERE idAvis = ?
");

$delete->bind_param(
    "i",
    $reviewId
);

$delete->execute();

echo json_encode([
    "success" => true
]);

$conn->close();