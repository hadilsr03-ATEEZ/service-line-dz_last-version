<?php

header("Content-Type: application/json");

require_once "connect.php";

$idWilaya = $_GET["idWilaya"] ?? 0;

$sql = "
SELECT
    idVille,
    nomVille
FROM ville
WHERE idWilaya = ?
ORDER BY nomVille
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $idWilaya
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$communes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $communes[] = $row;
}

echo json_encode($communes);