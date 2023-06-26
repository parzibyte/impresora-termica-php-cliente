<?php
if (!isset($_GET["id"])) {
    exit("No hay id");
}
$id = $_GET["id"];
$datos = [
    "id" => $id,
    "nombreImpresora" => "PT210",
    "productos" => [
        [
            "nombre" => "Alcohol isopropílico",
            "precio" => 20,
        ],
        [
            "nombre" => "Mouse razer",
            "precio" => 500,
        ],
    ],
    "fecha" => date("Y-m-d"),
];
echo json_encode($datos);
