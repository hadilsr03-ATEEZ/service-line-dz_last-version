<?php

header('Content-Type: application/json');

require_once 'connect.php';

$emailOrPhone = $_POST['emailOrPhone'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($emailOrPhone) || empty($password)) {

    echo json_encode([
        "error" => "Please fill all fields"
    ]);

    exit;
}

$sql = "
SELECT *
FROM utilisateur
WHERE email = ?
OR telephone = ?
LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $emailOrPhone,
    $emailOrPhone
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {

    echo json_encode([
        "error" => "Invalid credentials"
    ]);

    exit;
}

$user = mysqli_fetch_assoc($result);

if (
    !password_verify(
        $password,
        $user['motDePasse']
    )
) {

    echo json_encode([
        "error" => "Invalid credentials"
    ]);

    exit;
}

$userId = $user['idUtilisateur'];

$userType = "client";

$clientId = null;

$checkArtisan = mysqli_query(
    $conn,
    "SELECT idArtisan
     FROM artisan
     WHERE idUtilisateur = $userId
     LIMIT 1"
);

if (mysqli_num_rows($checkArtisan) > 0) {
    $userType = "provider";
}

$checkClient = mysqli_query(
    $conn,
    "SELECT idClient
     FROM client
     WHERE idUtilisateur = $userId
     LIMIT 1"
);

if (mysqli_num_rows($checkClient) > 0) {

    $client = mysqli_fetch_assoc($checkClient);

    $clientId = $client['idClient'];
}

echo json_encode([
    "success" => true,
    "userId" => $user['idUtilisateur'],
    "clientId" => $clientId,
    "fullName" => $user['nomComplet'],
    "userType" => $userType
]);