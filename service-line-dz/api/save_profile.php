<?php

header("Content-Type: application/json");

include "connect.php";

$data =
    json_decode(
        file_get_contents(
            "php://input"
        )
    );

if (
    !$data ||
    !isset(
        $data->userId,
        $data->profileId
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
        "error" => "Client not found"
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
        "error" => "Profile not found"
    ]);

    exit;
}

$idArtisan =
    $artisan["idArtisan"];

/* =========================
   Check Existing Favorite
========================= */

$stmt = $conn->prepare("
SELECT idFavori
FROM favori
WHERE idClient = ?
AND idArtisan = ?
");

$stmt->bind_param(
    "ii",
    $idClient,
    $idArtisan
);

$stmt->execute();

$result =
    $stmt->get_result();

/* =========================
   Remove Favorite
========================= */

if (
    $result->num_rows > 0
) {

    $stmt = $conn->prepare("
    DELETE FROM favori
    WHERE idClient = ?
    AND idArtisan = ?
    ");

    $stmt->bind_param(
        "ii",
        $idClient,
        $idArtisan
    );

    $stmt->execute();

    echo json_encode([
        "saved" => false
    ]);

}

/* =========================
   Add Favorite
========================= */

else {

    $stmt = $conn->prepare("
    INSERT INTO favori
    (
        idClient,
        idArtisan
    )
    VALUES
    (
        ?, ?
    )
    ");

    $stmt->bind_param(
        "ii",
        $idClient,
        $idArtisan
    );

    $stmt->execute();

    echo json_encode([
        "saved" => true
    ]);
}

$conn->close();

?>
