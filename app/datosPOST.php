<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=UTF-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Método no permitido');
}

function obtenerTexto(array $origen, string $clave): string
{
    $valor = $origen[$clave] ?? '';
    return is_string($valor) ? trim($valor) : '';
}

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$nombre = obtenerTexto($_POST, 'nombre');
$edadOriginal = obtenerTexto($_POST, 'edad');
$edad = filter_var(
    $edadOriginal,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 0, 'max_range' => 130]]
);
$datosValidos = $nombre !== '' && $edad !== false;

if (!$datosValidos) {
    http_response_code(400);
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Datos recibidos mediante POST</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main>
    <h1>Resultado de la petición POST</h1>

    <?php if ($datosValidos): ?>
      <p>Bienvenido, <strong><?= escapar($nombre) ?></strong>.</p>
      <p>Tu edad es <strong><?= escapar((string) $edad) ?></strong>.</p>
      <p class="detalle">Los datos se han recibido en el cuerpo de la petición.</p>
    <?php else: ?>
      <p class="error">Debes indicar un nombre y una edad válida entre 0 y 130.</p>
    <?php endif; ?>

    <p><a href="formularioPOST.html">Volver al formulario POST</a></p>
  </main>
</body>
</html>
