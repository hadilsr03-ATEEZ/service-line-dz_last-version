<?php

header("Content-Type: application/json");

include "connect.php"; 

$statistics = [];

/* Verified Providers */

$query = "

SELECT COUNT(*) AS total

FROM artisan

WHERE statut = 'APPROUVE'

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$statistics["verifiedProviders"] = (int)$row["total"];



/* Registered Clients */

$query = "

SELECT COUNT(*) AS total

FROM client

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$statistics["registeredClients"] = (int)$row["total"];



/* Average Rating */

$query = "

SELECT ROUND(AVG(note),1) AS avgRating

FROM avis

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$statistics["averageRating"] =
    $row["avgRating"] ?? 0;



/* Wilayas Covered */

$query = "

SELECT COUNT(DISTINCT v.idWilaya) AS total

FROM profil_artisan pa

JOIN ville v

ON pa.idVille = v.idVille

JOIN artisan a

ON pa.idArtisan = a.idArtisan

WHERE a.statut = 'APPROUVE'

";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$statistics["wilayasCovered"] = (int)$row["total"];



echo json_encode($statistics);

?>