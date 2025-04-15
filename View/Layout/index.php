<!DOCTYPE html>
<html lang="ptBR" data-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>AutoCare<?= isset($titulo) ? " - " . $titulo : "" ?></title>

    <script src="/<?= BASE_DIR_NAME; ?>/public/js/tailwind.min.js"></script>

    <link rel="stylesheet" href="/<?= BASE_DIR_NAME; ?>/public/css/tailwind.css">
    
    <?php
    if (isset($css)) {
        echo "<link rel='stylesheet' href='".BASE_DIR_NAME."/view/$css'>";
    }
    ?>

    <link href="/<?= BASE_DIR_NAME; ?>/public/fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="/<?= BASE_DIR_NAME; ?>/public/fontawesome/css/brands.css" rel="stylesheet" />
    <link href="/<?= BASE_DIR_NAME; ?>/public/fontawesome/css/solid.css" rel="stylesheet" />
</head>

<body class="bg-white dark:bg-zinc-950 flex min-h-screen m-0 text-black dark:text-white">
    <?php include VIEWS . "Layout/" . (isset($_SESSION["usuario"]) ? "logged.php" : "not-logged.php"); ?>
</body>

</html>