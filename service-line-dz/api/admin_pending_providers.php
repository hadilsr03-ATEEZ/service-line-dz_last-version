<?php

header("Content-Type: application/json");

include "connect.php";


$sql = "

SELECT

a.idArtisan,

u.nomComplet,

p.idProfil,

p.photoProfil,

c.nomCategorie,

v.nomVille


FROM artisan a


INNER JOIN utilisateur u

ON a.idUtilisateur = u.idUtilisateur


LEFT JOIN profil_artisan p

ON a.idArtisan = p.idArtisan


LEFT JOIN categorie_artisan ca

ON p.idProfil = ca.idProfil

AND ca.type='MAIN'


LEFT JOIN categorie c

ON ca.idCategorie = c.idCategorie


LEFT JOIN ville v

ON p.idVille = v.idVille



WHERE a.statut='EN_ATTENTE'


";


$result =
$conn->query($sql);


$providers=[];


while($row=$result->fetch_assoc()){


$providers[]=$row;


}



echo json_encode($providers);


?>