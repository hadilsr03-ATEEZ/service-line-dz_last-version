<?php

header("Content-Type: application/json");
include "connect.php";

$sql = "

SELECT

a.idAvis,

uClient.nomComplet AS reviewer,

uArtisan.nomComplet AS provider,

a.note,

a.commentaire,

a.dateCreation,

a.status

FROM avis a

LEFT JOIN client c
ON a.idClient = c.idClient

LEFT JOIN utilisateur uClient
ON c.idUtilisateur = uClient.idUtilisateur


LEFT JOIN artisan ar
ON a.idArtisan = ar.idArtisan

LEFT JOIN utilisateur uArtisan
ON ar.idUtilisateur = uArtisan.idUtilisateur


ORDER BY a.dateCreation DESC

";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "success" => false,
        "error" => $conn->error
    ]);
    exit;
}

$reviews = [];

while ($row = $result->fetch_assoc()) {

    $reviews[] = [
        "idReview" => $row["idAvis"],
        "reviewer" => $row["reviewer"],
        "provider" => $row["provider"],
        "rating" => $row["note"],
        "comment" => $row["commentaire"],
        "date" => $row["dateCreation"],
        "status" => $row["status"]
    ];
}

echo json_encode($reviews);

$conn->close();

?>