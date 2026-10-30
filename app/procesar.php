<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=UTF-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Este recurso solo admite peticiones POST.');
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
$curso = obtenerTexto($_POST, 'curso');
$datosValidos = $nombre !== '' && $curso !== '';

if (!$datosValidos) {
    http_response_code(400);
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Procesamiento de datos POST</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main>
    <h1>Datos recibidos mediante POST</h1>

    <?php if ($datosValidos): ?>
      <dl>
        <dt>Nombre</dt>
        <dd><?= escapar($nombre) ?></dd>
        <dt>Curso</dt>
        <dd><?= escapar($curso) ?></dd>
      </dl>
      <p class="detalle">
        Los datos se han recibido con el tipo
        <code>application/x-www-form-urlencoded</code>.
      </p>
    <?php else: ?>
      <p class="error">Debes enviar los campos <code>nombre</code> y <code>curso</code>.</p>
    <?php endif; ?>
  </main>
</body>
</html>
