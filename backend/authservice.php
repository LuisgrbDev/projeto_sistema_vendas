<?php

require_once 'entity/usario.php';
require_once 'dao/UsarioDAO.php';

$type = filter_input(INPUT_POST, "type");
if ($type === "register") {
    //login de registro do usuário
    $new_nome = filter_input(INPUT_POST, "new_nome");
    $new_email = filter_input(INPUT_POST, "new_email", FILTER_SANITIZE_EMAIL);
    $new_password = filter_input(INPUT_POST, "new_password");
    $confirm_password = filter_input(INPUT_POST, "confirm_password");
    if ($new_email && $new_nome && $new_password) {
        if($new_password === $confirm_password){

       
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $usuario = new Usuario(null, $new_nome, $hashed_password, $new_email, null, 1, null, null);
        $usuarioDAO = new UsuarioDAO();
       $succes =  $usuarioDAO->create($usuario);

        if($succes){
        header("location: index.php");
        exit();
        }else{
            //tratar falha de registro banco de dados
        }
    } else{

    }
    }else{

    }

} elseif ($type === "login") {
}
