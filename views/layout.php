<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OdonSecure</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link rel="icon" href="/build/img/favicon.png" as="icon">
    <link rel="preload" href="/build/css/app.css" as="style">
    <link rel="stylesheet" href="/build/css/app.css" as="style">
</head>
<body>
    <main class="contenedor">
        <section class="content">
        <?php echo $contenido; ?>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>