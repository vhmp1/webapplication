<?php

$fileName = $_FILES['file']['name'];
$fileType = $_FILES['file']['type'];
$fileContent = file_get_contents($_FILES['file']['tmp_name']);
// $dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);
$dataUrl = base64_encode($fileContent);
$json = json_encode(array(
  'name' => $fileName,
  'type' => $fileType,
  'dataUrl' => $dataUrl,
));

echo $json;
?>