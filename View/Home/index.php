<?php
  $usuario = $_SESSION["usuario"];
  $tipo = $usuario->tipo;
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
  <?php 
    if($tipo == "prestador" || $tipo == "funcionario") {
      require COMPONENTS."Home/Catalogo/index.php";
    }
  ?>

  <?php 
    if($tipo == "prestador" || $tipo == "funcionario") {
      require COMPONENTS."Home/CompletarPerfil/index.php";
    }
  ?>

  <?php 
    if($tipo == "usuario") {
      require COMPONENTS."Home/Veiculos/index.php";
    }
  ?>

  <?php 
    if($tipo == "usuario") {
      require COMPONENTS."Home/EncontrarPrestadores/index.php";
    }
  ?>
</div>
