<?php

header("Content-Type: application/json");

include "connect.php";

$profileId = $_GET["id"] ?? null;

if (!$profileId) {

    echo json_encode([
        "error" => "Profile ID missing"
    ]);

    exit;
}

/* =========================
   Get Profile Info
========================= */

$sql = "
SELECT

    p.*,

    u.nomComplet,
    u.email,
    u.telephone,
    u.dateCreation,

    a.statut,

    v.nomVille,
    w.nomWilaya

FROM profil_artisan p

INNER JOIN artisan a
    ON p.idArtisan = a.idArtisan

INNER JOIN utilisateur u
    ON a.idUtilisateur = u.idUtilisateur

INNER JOIN ville v
    ON p.idVille = v.idVille

INNER JOIN wilaya w
    ON v.idWilaya = w.idWilaya

WHERE p.idProfil = ?

LIMIT 1
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $profileId
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    echo json_encode([
        "error" => "Profile not found"
    ]);

    exit;
}

$profile = $result->fetch_assoc();

/* =========================
   Main Category
========================= */

$mainCategorySql = "
SELECT
    c.idCategorie,
    c.nomCategorie

FROM categorie_artisan ca

INNER JOIN categorie c
    ON ca.idCategorie = c.idCategorie

WHERE
    ca.idProfil = ?
    AND ca.type = 'MAIN'

LIMIT 1
";

$mainStmt =
    $conn->prepare($mainCategorySql);

$mainStmt->bind_param(
    "i",
    $profileId
);

$mainStmt->execute();

$mainCategory =
    $mainStmt
        ->get_result()
        ->fetch_assoc();

/* =========================
   Additional Categories
========================= */

$additionalSql = "
SELECT
    c.idCategorie,
    c.nomCategorie

FROM categorie_artisan ca

INNER JOIN categorie c
    ON ca.idCategorie = c.idCategorie

WHERE
    ca.idProfil = ?
    AND ca.type = 'ADDITIONAL'
";

$additionalStmt =
    $conn->prepare($additionalSql);

$additionalStmt->bind_param(
    "i",
    $profileId
);

$additionalStmt->execute();

$additionalResult =
    $additionalStmt->get_result();

$additionalCategories = [];

while (
    $row =
    $additionalResult->fetch_assoc()
) {

    $additionalCategories[] = $row;
}

/* =========================
   Services
========================= */

$servicesSql = "
SELECT *
FROM service
WHERE idProfil = ?
";

$servicesStmt =
    $conn->prepare($servicesSql);

$servicesStmt->bind_param(
    "i",
    $profileId
);

$servicesStmt->execute();

$servicesResult =
    $servicesStmt->get_result();

$services = [];

while (
    $row =
    $servicesResult->fetch_assoc()
) {

    $services[] = $row;
}

/* =========================
   Availability
========================= */

$availabilitySql = "
SELECT *
FROM disponibilite
WHERE idProfil = ?
ORDER BY jourSemaine
";

$availabilityStmt =
    $conn->prepare($availabilitySql);

$availabilityStmt->bind_param(
    "i",
    $profileId
);

$availabilityStmt->execute();

$availabilityResult =
    $availabilityStmt->get_result();

$availability = [];

while (
    $row =
    $availabilityResult->fetch_assoc()
) {

    $availability[] = $row;
}

/* =========================
   Response
========================= */

echo json_encode([

    "success" => true,

    "profile" => $profile,

    "mainCategory" =>
        $mainCategory,

    "additionalCategories" =>
        $additionalCategories,

    "services" =>
        $services,

    "availability" =>
        $availability

]);

$conn->close();

?>
