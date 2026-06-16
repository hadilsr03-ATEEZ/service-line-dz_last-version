<?php

header("Content-Type: application/json");

require_once "connect.php";

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->userId)) {
    echo json_encode([
        "error" => "Missing userId"
    ]);
    exit;
}

$userId = $data->userId;

$sql = "
SELECT
    nomComplet,
    telephone
FROM utilisateur
WHERE idUtilisateur = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $userId
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {

    echo json_encode([
        "error" => "User not found"
    ]);

    exit;
}

$user = mysqli_fetch_assoc($result);

echo json_encode([
    "fullName" => $user["nomComplet"],
    "phone" => $user["telephone"]
]);