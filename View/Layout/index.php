<!DOCTYPE html>
<html lang="ptBR" data-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>AutoCare<?= isset($titulo) ? " - " . $titulo : "" ?></title>

    
    <script src="public/js/tailwind.min.js"></script>
    <link rel="stylesheet" href="public/css/tailwind.css">
    <?php
    if (isset($css)) {
        echo "<link rel='stylesheet' href='view/" . $css . "'>";
    }
    ?>
</head>

<body class="bg-white dark:bg-background-dark flex min-h-screen m-0 text-black dark:text-white">
    <?php include VIEWS . $view; ?>
</body>

</html>