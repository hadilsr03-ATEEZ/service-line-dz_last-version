<?php

header("Content-Type: application/json");

include "connect.php";

$userId =
    $_GET["userId"]
    ?? null;

$profileId =
    $_GET["profileId"]
    ?? null;

if (
    !$userId ||
    !$profileId
) {

    echo json_encode([
        "saved" => false
    ]);

    exit;
}

/* =========================
   Get Client ID
========================= */

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

$client =
$stmt
->get_result()
->fetch_assoc();

if (!$client) {

    echo json_encode([
        "saved" => false
    ]);

    exit;
}

$idClient =
    $client["idClient"];

/* =========================
   Get Artisan ID
========================= */

$stmt = $conn->prepare("
SELECT idArtisan
FROM profil_artisan
WHERE idProfil = ?
");

$stmt->bind_param(
    "i",
    $profileId
);

$stmt->execute();

$artisan =
$stmt
->get_result()
->fetch_assoc();

if (!$artisan) {

    echo json_encode([
        "saved" => false
    ]);

    exit;
}

$idArtisan =
    $artisan["idArtisan"];

/* =========================
   Check Favorite
========================= */

$stmt = $conn->prepare("
SELECT idFavori
FROM favori
WHERE idClient = ?
AND idArtisan = ?
LIMIT 1
");

$stmt->bind_param(
    "ii",
    $idClient,
    $idArtisan
);

$stmt->execute();

$result =
    $stmt->get_result();

echo json_encode([
    "saved" =>
        $result->num_rows > 0
]);

$stmt->close();
$conn->close();

?>
