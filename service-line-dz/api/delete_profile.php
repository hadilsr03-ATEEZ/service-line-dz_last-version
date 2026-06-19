<?php

header("Content-Type: application/json");

include "connect.php";

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$profileId = $data["profileId"] ?? 0;

if (!$profileId) {

    echo json_encode([
        "error" => "Missing profile id"
    ]);

    exit;
}

$conn->begin_transaction();

$getProfile = $conn->prepare("
SELECT
    idArtisan,
    photoProfil,
    photoCouverture,
    portfolio,
    diplomes
FROM profil_artisan
WHERE idProfil = ?
");

$getProfile->bind_param(
    "i",
    $profileId
);

$getProfile->execute();

$profile =
$getProfile
->get_result()
->fetch_assoc();

$artisanId = $profile["idArtisan"];

if (!$profile) {

    $conn->rollback();

    echo json_encode([
        "error" => "Profile not found"
    ]);

    exit;
}

/* =========================
   Delete Uploaded Files
========================= */

$files = [];

// Profile photo
if (!empty($profile["photoProfil"])) {
    $files[] = "../" . $profile["photoProfil"];
}

// Cover photo
if (!empty($profile["photoCouverture"])) {
    $files[] = "../" . $profile["photoCouverture"];
}

// Portfolio
$portfolio =
    json_decode(
        $profile["portfolio"] ?? "[]",
        true
    );

if (is_array($portfolio)) {

    foreach ($portfolio as $file) {

        $files[] = "../" . $file;

    }

}

// Diplomas
$diplomes =
    json_decode(
        $profile["diplomes"] ?? "[]",
        true
    );

if (is_array($diplomes)) {

    foreach ($diplomes as $file) {

        $files[] = "../" . $file;

    }

}

// Delete every file
foreach ($files as $file) {

    if (file_exists($file)) {

        unlink($file);

    }

}

/***************************
 Delete Reviews
****************************/

$deleteAvis = $conn->prepare("
DELETE FROM avis
WHERE idArtisan = ?
");

$deleteAvis->bind_param(
    "i",
    $artisanId
);

if (!$deleteAvis->execute()) {

    $conn->rollback();

    echo json_encode([
        "error" => $deleteAvis->error
    ]);

    exit;
}

/* =========================
   Delete Profile
========================= */

$deleteStmt = $conn->prepare("
DELETE FROM profil_artisan
WHERE idProfil = ?
");

$deleteStmt->bind_param(
    "i",
    $profileId
);

if (!$deleteStmt->execute()) {

    $conn->rollback();

    echo json_encode([
        "error" => $deleteStmt->error
    ]);

    exit;
}

$conn->commit();

echo json_encode([
    "success" => true
]);

$conn->close();

exit;