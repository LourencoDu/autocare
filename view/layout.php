<!DOCTYPE html>
<html>
<head>
    <title>AutoCare<?= $data['title'] ? " - ".$data['title'] : "" ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $name ?>.css">
</head>
<body>
    <?php include "view/{$name}.php"; ?>
</body>
</html>