<?php

header("Content-Type: application/json");

require_once "connect.php";

$sql = "
SELECT
    idWilaya,
    nomWilaya
FROM wilaya
ORDER BY idWilaya
";

$result = mysqli_query($conn, $sql);

$wilayas = [];

while ($row = mysqli_fetch_assoc($result)) {
    $wilayas[] = $row;
}

echo json_encode($wilayas);