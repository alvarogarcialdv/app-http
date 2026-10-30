<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store');

$visitasAnteriores = filter_input(INPUT_COOKIE, 'visitas', FILTER_VALIDATE_INT);

if ($visitasAnteriores === false || $visitasAnteriores === null || $visitasAnteriores < 0) {
    $visitasAnteriores = 0;
}

$visitas = $visitasAnteriores + 1;
$caducidad = time() + (365 * 24 * 60 * 60);

setcookie('visitas', (string) $visitas, [
    'expires' => $caducidad,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax',
]);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cookie creada por el servidor</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main>
    <p><a href="index.html">Volver al inicio</a></p>
    <h1>Cookie HTTP creada por PHP</h1>

    <?php if ($visitas === 1): ?>
      <p>Esta es tu primera visita.</p>
    <?php else: ?>
      <p>Has visitado esta página <strong><?= $visitas ?></strong> veces.</p>
    <?php endif; ?>

    <p class="detalle">
      La respuesta crea o actualiza la cookie <code>visitas</code> mediante la cabecera
      <code>Set-Cookie</code>. En la siguiente visita, el navegador la enviará en la
      cabecera <code>Cookie</code>.
    </p>
    <p><a href="cookies.php">Volver a visitar la página</a></p>
  </main>
</body>
</html>
