<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../model/assets/php/db.php'; 
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
if ($tipo === "not-destaque") {
}
?>