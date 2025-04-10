<!DOCTYPE html>
<html>
<head>
    <title>AutoCare<?= $data['title'] ? " - ".$data['title'] : "" ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $data['name'] ?>.css">
</head>
<body>
    <?= $data['content'] ?? '' ?>
</body>
</html>