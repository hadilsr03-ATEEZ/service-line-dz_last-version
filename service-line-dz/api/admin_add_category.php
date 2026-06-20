<?php

header("Content-Type: application/json");
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$nomCategorie = trim($data["nomCategorie"] ?? "");

if ($nomCategorie === "") {
    echo json_encode([
        "success" => false,
        "message" => "Category name is required"
    ]);
    exit;
}

// prevent duplicates
$check = $conn->prepare("SELECT idCategorie FROM categorie WHERE nomCategorie = ?");
$check->bind_param("s", $nomCategorie);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Category already exists"
    ]);
    exit;
}

// insert
$stmt = $conn->prepare("INSERT INTO categorie (nomCategorie) VALUES (?)");
$stmt->bind_param("s", $nomCategorie);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Insert failed"
    ]);

}

$conn->close();

?>