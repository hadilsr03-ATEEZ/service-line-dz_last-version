<?php

header("Content-Type: application/json");

include "connect.php";


$sql = "

SELECT

u.idUtilisateur,
u.nomComplet,
u.email,
u.dateCreation,

p.idProfil,

CASE

WHEN ar.idArtisan IS NOT NULL
THEN 'Artisan'

WHEN c.idClient IS NOT NULL
THEN 'Client'

ELSE 'Admin'

END AS type,


p.photoProfil


FROM utilisateur u


LEFT JOIN artisan ar
ON u.idUtilisateur = ar.idUtilisateur


LEFT JOIN client c
ON u.idUtilisateur = c.idUtilisateur


LEFT JOIN profil_artisan p
ON ar.idArtisan = p.idArtisan


ORDER BY u.dateCreation DESC

LIMIT 10


";


$result = $conn->query($sql);


$users=[];


while($row=$result->fetch_assoc()){

$users[]=$row;

}


echo json_encode($users);


$conn->close();

?>