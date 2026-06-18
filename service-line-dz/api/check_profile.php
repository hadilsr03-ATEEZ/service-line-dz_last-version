<?php

header("Content-Type: application/json");

include "connect.php";

$userId = $_GET["userId"] ?? 0;

if (!$userId) {

    echo json_encode([
        "error" => "Missing user id"
    ]);

    exit;
}

/* Get Artisan */

$artisanStmt = $conn->prepare("
SELECT idArtisan
FROM artisan
WHERE idUtilisateur = ?
LIMIT 1
");

$artisanStmt->bind_param(
    "i",
    $userId
);

$artisanStmt->execute();

$artisanResult =
    $artisanStmt->get_result();

if ($artisanResult->num_rows === 0) {

    echo json_encode([
        "hasProfile" => false
    ]);

    exit;
}

$idArtisan =
    $artisanResult
    ->fetch_assoc()["idArtisan"];

/* Check Profile */

$profileStmt = $conn->prepare("
SELECT idProfil
FROM profil_artisan
WHERE idArtisan = ?
LIMIT 1
");

$profileStmt->bind_param(
    "i",
    $idArtisan
);

$profileStmt->execute();

$profileResult =
    $profileStmt->get_result();

if ($profileResult->num_rows > 0) {

    $profile =
        $profileResult->fetch_assoc();

    echo json_encode([

        "hasProfile" => true,

        "idProfil" =>
            $profile["idProfil"]

    ]);

} else {

    echo json_encode([

        "hasProfile" => false

    ]);

}

$conn->close();