<?php

header("Content-Type: application/json");

include "connect.php";

$saved =
    $_GET["saved"] ?? "";

$userId =
    $_GET["userId"] ?? "";

$categoryId =
    $_GET["category"] ?? "";

$wilayaId =
    $_GET["wilaya"] ?? "";


$where = [
    "a.statut = 'APPROUVE'"
];

if (!empty($categoryId)) {

    $where[] = "
    p.idProfil IN (
        SELECT idProfil
        FROM categorie_artisan
        WHERE idCategorie = " . (int)$categoryId . "
    )";
}

if (!empty($wilayaId)) {

    $where[] =
        "w.idWilaya = " .
        (int)$wilayaId;
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

$client =
    $stmt
    ->get_result()
    ->fetch_assoc();


if (
    $saved == "1" &&
    !empty($userId)
) {

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

    if ($client) {

        $where[] =
        "a.idArtisan IN (
            SELECT idArtisan
            FROM favori
            WHERE idClient = " .
            (int)$client["idClient"] .
        ")";
    }
}
    

$sql = "
SELECT

    p.idProfil,
    p.photoProfil,
    p.serviceAreas,
    p.urgence,

    u.nomComplet,

    a.idArtisan,
    a.statut,

    v.nomVille,
    w.nomWilaya,

    c.nomCategorie AS mainCategory,
    
    GROUP_CONCAT(
        DISTINCT cAdd.nomCategorie
        SEPARATOR ','
    ) AS additionalCategories,

    COALESCE(
        ROUND(AVG(av.note), 1),
        0
    ) AS averageRating,

    COUNT(DISTINCT av.idAvis) AS reviewsCount

FROM profil_artisan p

INNER JOIN artisan a
    ON p.idArtisan = a.idArtisan

INNER JOIN utilisateur u
    ON a.idUtilisateur = u.idUtilisateur

INNER JOIN ville v
    ON p.idVille = v.idVille

INNER JOIN wilaya w
    ON v.idWilaya = w.idWilaya

LEFT JOIN categorie_artisan caMain
    ON p.idProfil = caMain.idProfil
    AND caMain.type = 'MAIN'

LEFT JOIN categorie c
    ON caMain.idCategorie = c.idCategorie

LEFT JOIN categorie_artisan caAdd
    ON p.idProfil = caAdd.idProfil
    AND caAdd.type = 'ADDITIONAL'

LEFT JOIN categorie cAdd
    ON caAdd.idCategorie = cAdd.idCategorie

LEFT JOIN avis av
    ON a.idArtisan = av.idArtisan

";

$sql .= "
WHERE " .
implode(
    " AND ",
    $where
);

$sql .= "

GROUP BY
    p.idProfil,
    p.photoProfil,
    p.serviceAreas,
    p.urgence,
    u.nomComplet,
    a.idArtisan,
    a.statut,
    v.nomVille,
    w.nomWilaya,
    c.nomCategorie

ORDER BY p.idProfil DESC
";

$result = $conn->query($sql);

if (!$result) {

    echo json_encode([
        "success" => false,
        "error" => $conn->error
    ]);

    exit;
}

$profiles = [];

while ($row = $result->fetch_assoc()) {

    $profiles[] = $row;
}

echo json_encode([
    "success" => true,
    "profiles" => $profiles
]);

$conn->close();

?>