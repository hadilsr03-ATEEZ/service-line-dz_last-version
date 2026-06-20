<?php

header("Content-Type: application/json");

include "connect.php";


$data =
json_decode(
file_get_contents("php://input"),
true
);


$id =
$data["idUtilisateur"];



$stmt =
$conn->prepare(

"DELETE FROM utilisateur
WHERE idUtilisateur=?"

);



$stmt->bind_param(
"i",
$id
);



if($stmt->execute()){


echo json_encode([

"success"=>true

]);


}

else{


echo json_encode([

"success"=>false,

"error"=>$conn->error

]);


}


$conn->close();


?>