<?php

header("Content-Type: application/json");

include "connect.php";


$sql = "

SELECT

c.idCategorie,

c.nomCategorie,

COUNT(ca.idProfil) AS totalProviders


FROM categorie c


LEFT JOIN categorie_artisan ca

ON c.idCategorie = ca.idCategorie


GROUP BY

c.idCategorie,

c.nomCategorie


ORDER BY

c.nomCategorie

";


$result =
$conn->query($sql);


$categories = [];


while($row = $result->fetch_assoc()){

    $categories[] = $row;

}


echo json_encode($categories);


$conn->close();

?>