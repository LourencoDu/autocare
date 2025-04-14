<!DOCTYPE html>
<html>
<head>
    <title>AutoCare<?= isset($titulo) ? " - ".$titulo: "" ?></title>
    <link rel="stylesheet" href="public/css/style.css"> 
    <?php
        if(isset($css)) {
            echo "<link rel='stylesheet' href='view/".$css."'>";
        }
    ?>   
    
</head>
<body>
    <?php include VIEWS.$view; ?>
</body>
</html>