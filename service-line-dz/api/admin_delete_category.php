<?php

header("Content-Type: application/json");
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$idCategorie = intval($data["idCategorie"] ?? 0);

if ($idCategorie <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid category ID"
    ]);
    exit;
}

/*
Optional safety check:
prevent delete if providers exist
*/

$check = $conn->prepare("
    SELECT COUNT(*) as total
    FROM categorie_artisan
    WHERE idCategorie = ?
");

$check->bind_param("i", $idCategorie);
$check->execute();

$result = $check->get_result();
$row = $result->fetch_assoc();

if ($row["total"] > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Cannot delete: category has providers"
    ]);

    exit;
}

// delete category
$stmt = $conn->prepare("
    DELETE FROM categorie
    WHERE idCategorie = ?
");

$stmt->bind_param("i", $idCategorie);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Delete failed"
    ]);

}

$conn->close();

?>