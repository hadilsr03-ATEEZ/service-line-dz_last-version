<?php

require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userType = $_POST['userType'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        die("Passwords do not match");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_prepare(
        $conn,
        "SELECT idUtilisateur FROM utilisateur WHERE email = ?"
    );
    
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    
    $result = mysqli_stmt_get_result($check);
    
    if (mysqli_num_rows($result) > 0) {
    
        header('Content-Type: application/json');
    
        echo json_encode([
            "error" => "Email already exists"
        ]);
    
        exit;
    }

    $sql = "INSERT INTO utilisateur
            (nomComplet, email, telephone, motDePasse)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $fullName,
        $email,
        $phone,
        $hashedPassword
    );

    mysqli_stmt_execute($stmt);

    $idUtilisateur = mysqli_insert_id($conn);

    if ($userType == "client") {

        mysqli_query(
            $conn,
            "INSERT INTO client (idUtilisateur)
             VALUES ($idUtilisateur)"
        );

    } else {

        mysqli_query(
            $conn,
            "INSERT INTO artisan (idUtilisateur)
             VALUES ($idUtilisateur)"
        );

    }

    header('Content-Type: application/json');
    
    echo json_encode([
        "success" => true
    ]);
}
?>