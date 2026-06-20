<?php

header("Content-Type: application/json");
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$idCategorie = intval($data["idCategorie"] ?? 0);
$nomCategorie = trim($data["nomCategorie"] ?? "");

if ($idCategorie <= 0 || $nomCategorie === "") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid data"
    ]);
    exit;
}

// check duplicate name (exclude current category)
$check = $conn->prepare("
    SELECT idCategorie 
    FROM categorie 
    WHERE nomCategorie = ? AND idCategorie != ?
");

$check->bind_param("si", $nomCategorie, $idCategorie);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Category already exists"
    ]);
    exit;
}

// update
$stmt = $conn->prepare("
    UPDATE categorie 
    SET nomCategorie = ?
    WHERE idCategorie = ?
");

$stmt->bind_param("si", $nomCategorie, $idCategorie);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Update failed"
    ]);

}

$conn->close();

?>