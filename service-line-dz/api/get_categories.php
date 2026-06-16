<?php

header("Content-Type: application/json");

include "connect.php";

$sql = "
SELECT
    idCategorie,
    nomCategorie
FROM categorie
ORDER BY nomCategorie
";

$result = $conn->query($sql);

$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);