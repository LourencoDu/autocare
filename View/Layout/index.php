<!DOCTYPE html>
<html lang="ptBR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>AutoCare<?= isset($titulo) ? " - " . $titulo : "" ?></title>

    <link rel="icon" type="image/x-icon" href="/<?= BASE_DIR_NAME; ?>/public/ico/favicon.ico">

    <script src="/<?= BASE_DIR_NAME; ?>/public/js/tailwind.min.js"></script>

    <link rel="stylesheet" href="/<?= BASE_DIR_NAME; ?>/public/css/tailwind.css">

    <?php
    if (isset($css)) {
        echo "<link rel='stylesheet' href='/" . BASE_DIR_NAME . "/view/$css'>";
    }
    ?>

    <link href="/<?= BASE_DIR_NAME; ?>/public/fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="/<?= BASE_DIR_NAME; ?>/public/fontawesome/css/brands.css" rel="stylesheet" />
    <link href="/<?= BASE_DIR_NAME; ?>/public/fontawesome/css/solid.css" rel="stylesheet" />
</head>

<body class="bg-gray-500/10 flex min-h-screen m-0 text-black">
    
    <div id="snackbar" class="hidden fixed bottom-5 right-5 z-50 px-4 py-3 rounded-lg bg-gray-800 text-white shadow-lg transition-opacity duration-300 opacity-0"></div>

    

    <?php include VIEWS . "Layout/" . (isset($_SESSION["usuario"]) ? "logged.php" : "not-logged.php"); ?>

    <?php
    include COMPONENTS . "modal/index.php";
    ?>

    <?php
    include COMPONENTS . "loading.php";
    ?>

    <script src="/<?= BASE_DIR_NAME ?>/public/js/inputmask.js"></script>

    <?php
    if (isset($js)) {
        echo "<script src='/" . BASE_DIR_NAME . "/view/$js'></script>";
    }
    ?>

    <script src="/<?= BASE_DIR_NAME ?>/public/js/api.js"></script>        
    <script src="/<?= BASE_DIR_NAME ?>/public/js/common.js"></script>
    <script src="/<?= BASE_DIR_NAME ?>/public/js/modal/form-modal.js"></script>
    <script src="/<?= BASE_DIR_NAME ?>/public/js/modal/delete-modal.js"></script>
    <script src="/<?= BASE_DIR_NAME ?>/public/js/snackbar.js"></script>
    <script src="/<?= BASE_DIR_NAME ?>/public/js/sidemenu.js"></script>
</body>

</html>