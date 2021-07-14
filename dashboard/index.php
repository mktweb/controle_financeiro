<?php
require_once('dashboard.php');

$dashboard = new Dashboard();

switch($_GET['page']) {
    case 'listar':
        $dashboard->listar();
        break;

    case 'adicionar':
        $dashboard->adicionar();
        break;
    
    case 'editar':
        $dashboard->editar();
        break;
    
    case 'remover':
        $dashboard->remover();
        break;

    case 'visualizar':
        $dashboard->visualizar();
        break;

    default: 
        $dashboard->index();
}
