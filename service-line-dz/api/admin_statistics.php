<?php

header("Content-Type: application/json");

include "connect.php";

$data = [];

$days = intval($_GET["days"] ?? 30);


// Total Reviews

$sql = "

SELECT COUNT(*) AS totalReviews

FROM avis

WHERE

status='VISIBLE'

AND

dateCreation >=

NOW() - INTERVAL $days DAY

";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$data["totalReviews"] =

$row["totalReviews"];



// Average Rating

$sql = "

SELECT

ROUND(

AVG(note),

1

)

AS averageRating

FROM avis

WHERE

status='VISIBLE'

AND

dateCreation >=

NOW() - INTERVAL $days DAY

";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$data["averageRating"] =

$row["averageRating"] ?? 0;



// Approved Providers

$sql = "

SELECT COUNT(*) AS approvedProviders

FROM artisan

WHERE statut='APPROUVE'

";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$data["approvedProviders"] =

$row["approvedProviders"];



// Rejected Providers

$sql = "

SELECT COUNT(*) AS rejectedProviders

FROM artisan

WHERE statut='REJETE'

";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$data["rejectedProviders"] =

$row["rejectedProviders"];



echo json_encode($data);

$conn->close();

?>