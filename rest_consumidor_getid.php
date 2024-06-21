<?php

$data = array("id"=>3);
$data = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/apis/rest_basico2.php?".$data);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$respond = curl_exec($ch);
curl_close($ch);
print_r($respond);



