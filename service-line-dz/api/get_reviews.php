<?php

header("Content-Type: application/json");

include "connect.php";

$profileId = $_GET["profileId"] ?? null;

if (!$profileId) {

    echo json_encode([
        "error" => "Profile ID missing"
    ]);

    exit;
}

/* =========================
   Get Artisan
========================= */

$artisanSql = "
SELECT idArtisan
FROM profil_artisan
WHERE idProfil = ?
LIMIT 1
";

$artisanStmt = $conn->prepare($artisanSql);

$artisanStmt->bind_param(
    "i",
    $profileId
);

$artisanStmt->execute();

$artisanResult =
    $artisanStmt->get_result();

$artisan =
    $artisanResult->fetch_assoc();

if (!$artisan) {

    echo json_encode([
        "error" => "Profile not found"
    ]);

    exit;
}

$idArtisan =
    $artisan["idArtisan"];

/* =========================
   Reviews
========================= */

$reviewsSql = "
SELECT

    a.*,
    c.idClient,
    u.nomComplet

FROM avis a

INNER JOIN client c
    ON a.idClient = c.idClient

INNER JOIN utilisateur u
    ON c.idUtilisateur = u.idUtilisateur

WHERE a.idArtisan = ?

ORDER BY a.dateCreation DESC
";

$reviewsStmt =
    $conn->prepare(
        $reviewsSql
    );

$reviewsStmt->bind_param(
    "i",
    $idArtisan
);

$reviewsStmt->execute();

$reviewsResult =
    $reviewsStmt->get_result();

$reviews = [];

$totalRating = 0;

while (
    $row =
    $reviewsResult->fetch_assoc()
) {

    $reviews[] = $row;

    $totalRating +=
        $row["note"];
}

$reviewsCount =
    count($reviews);

$averageRating =
    $reviewsCount > 0
        ? round(
            $totalRating /
            $reviewsCount,
            1
        )
        : 0;

echo json_encode([

    "success" => true,

    "averageRating" =>
        $averageRating,

    "reviewsCount" =>
        $reviewsCount,

    "reviews" =>
        $reviews

]);

$conn->close();