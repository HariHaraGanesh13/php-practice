<?php
header("Content-type: application/json");
require "config.php";
global $pdo;

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($q) < 3) {
    echo json_encode(["results" => []]);
    exit;
}
//remove wildcard abuse
$clean = str_replace(['%','_'],'',$q);

if(strlen($clean)<3){
    echo json_encode(["results" => []]);
    exit;
}


$stmt = $pdo->prepare("SELECT id, name, category, price 
                             FROM products
                             WHERE name LIKE ? or category LIKE ? or sku Like ?
                             LIMIT 10"
);

$term = "%" . $q . "%";
$stmt->execute([$term, $term, $term]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["results" => $data]);