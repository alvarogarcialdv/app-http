<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

$metodo = $_SERVER['REQUEST_METHOD'] ?? '';

if (!in_array($metodo, ['GET', 'POST'], true)) {
    header('Allow: GET, POST');
    http_response_code(405);
}

$cabeceras = function_exists('getallheaders') ? getallheaders() : [];

if (!is_array($cabeceras)) {
    $cabeceras = [];
}

$respuesta = [
    'method' => $metodo,
    'args' => $_GET === [] ? new stdClass() : $_GET,
    'form' => $_POST === [] ? new stdClass() : $_POST,
    'headers' => $cabeceras === [] ? new stdClass() : $cabeceras,
];

echo json_encode(
    $respuesta,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
echo PHP_EOL;
