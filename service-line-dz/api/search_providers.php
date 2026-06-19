<?php

header("Content-Type: application/json");

require_once "connect.php";

$category = $_GET["category"] ?? "";
$wilaya   = $_GET["wilaya"] ?? "";


$sql = "

SELECT DISTINCT

    pa.idProfil,

    u.nomComplet,

    pa.photoProfil,

    pa.photoCouverture,

    pa.description,

    pa.urgence,

    v.nomVille,

    w.nomWilaya,

    c.nomCategorie AS mainCategory

FROM profil_artisan pa

INNER JOIN artisan a
ON pa.idArtisan = a.idArtisan

INNER JOIN utilisateur u
ON a.idUtilisateur = u.idUtilisateur

INNER JOIN ville v
ON pa.idVille = v.idVille

INNER JOIN wilaya w
ON v.idWilaya = w.idWilaya

LEFT JOIN categorie_artisan caMain
ON pa.idProfil = caMain.idProfil
AND caMain.type = 'MAIN'

LEFT JOIN categorie c
ON caMain.idCategorie = c.idCategorie

";

$where = [];

$params = [];
$types = "";

if (!empty($category)) {

    $where[] = "
    pa.idProfil IN
    (
        SELECT idProfil
        FROM categorie_artisan
        WHERE idCategorie = ?
    )
    ";

    $params[] = $category;
    $types .= "i";

}

if (!empty($wilaya)) {

    $where[] = "v.idWilaya = ?";

    $params[] = $wilaya;
    $types .= "i";

}

if (!empty($where)) {

    $sql .= " WHERE " . implode(" AND ", $where);

}

$sql .= "

ORDER BY

u.nomComplet

";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {

    mysqli_stmt_bind_param(
        $stmt,
        $types,
        ...$params
    );

}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$providers = [];

while ($row = mysqli_fetch_assoc($result)) {

    $providers[] = $row;

}

echo json_encode([
    "success" => true,
    "providers" => $providers
]);

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>