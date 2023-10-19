<?php 
$url = file_get_contents('http://localhost:8080/geoserver/DiemQuangNinh/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=DiemQuangNinh%3AVungQuangNinh&outputFormat=application%2Fjson');
echo($url);



?>