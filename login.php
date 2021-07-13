<?php
session_start();

if ( empty($_POST) ) {
    header('Location: index.php');
    exit;
}


require_once('db/usuarios.php');

$usuarios = new Usuarios();

$user = $usuarios->get('email', $_POST['email']);

if ( empty($user) ) {
    $_SESSION['alert'] = 'danger';
    $_SESSION['mensagem'] = 'Usuário não encontrado.';
    header('Location: index.php');
} else if( !password_verify($_POST['senha'], $user->senha) ) {
    $_SESSION['alert'] = 'danger';
    $_SESSION['mensagem'] = 'Senha não confere.';
    header('Location: index.php');
} else {
    $_SESSION['nome'] = $user->nome;
    $_SESSION['email'] = $user->email;
    header('Location: dashboard');
}

?>