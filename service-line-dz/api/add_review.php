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
        $data->profileId,
        $data->rating,
        $data->comment
    )
) {

    echo json_encode([
        "error" => "Missing data"
    ]);

    exit;
}

$userId =
    (int)$data->userId;

$profileId =
    (int)$data->profileId;

$rating =
    (int)$data->rating;

$comment =
    trim($data->comment);

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
        "error" =>
            "Only clients can leave reviews"
    ]);

    exit;
}

$idClient =
    $clientResult
        ->fetch_assoc()["idClient"];

/* Get Artisan */

$artisanStmt =
    $conn->prepare("
    SELECT idArtisan
    FROM profil_artisan
    WHERE idProfil = ?
    LIMIT 1
");

$artisanStmt->bind_param(
    "i",
    $profileId
);

$artisanStmt->execute();

$artisanResult =
    $artisanStmt->get_result();

if (
    $artisanResult->num_rows === 0
) {

    echo json_encode([
        "error" =>
            "Profile not found"
    ]);

    exit;
}

$idArtisan =
    $artisanResult
        ->fetch_assoc()["idArtisan"];

/* Prevent duplicate review */

$check =
    $conn->prepare("
    SELECT idAvis
    FROM avis
    WHERE idClient = ?
    AND idArtisan = ?
");

$check->bind_param(
    "ii",
    $idClient,
    $idArtisan
);

$check->execute();

if (
    $check
    ->get_result()
    ->num_rows > 0
) {

    echo json_encode([
        "error" =>
            "You already reviewed this provider"
    ]);

    exit;
}

/* Insert Review */

$insert =
    $conn->prepare("
    INSERT INTO avis
    (
        idClient,
        idArtisan,
        note,
        commentaire
    )
    VALUES (?, ?, ?, ?)
");

$insert->bind_param(
    "iiis",
    $idClient,
    $idArtisan,
    $rating,
    $comment
);

$insert->execute();

echo json_encode([
    "success" => true
]);

$conn->close();