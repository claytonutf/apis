<?php

$data = array("id"=>2, "nome"=>"Senac", "telefone"=>"(42)9999-9991", "email"=>"email@pr.senac.br", "datanasc"=>"2000-09-11");
$data = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/apis/rest_basico.php");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$respond = curl_exec($ch);
curl_close($ch);
print_r($respond);





