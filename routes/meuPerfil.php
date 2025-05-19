<?php

use AutoCare\Controller\MeuPerfilController;

switch ($url) {
  case '/meu-perfil':
    (new MeuPerfilController())->index();
    exit;
}
