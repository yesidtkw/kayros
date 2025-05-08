<?php
$host = "cpanel4-co.conexcol.net:3306";
$usuario = "kayrosco_admin";
$contrasena = "28982700aA?+";
$basedatos = "kayrosco_tenoplus";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}
?>
