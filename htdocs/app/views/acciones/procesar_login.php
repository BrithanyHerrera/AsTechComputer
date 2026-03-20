<?php
session_start();
require '../config/conexion.db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

 
    if (empty($usuario) || empty($password)) {
        die("Por favor, llena todos los campos.");
    }


    $stmt = $pdo->prepare("SELECT id, password_hash FROM usuarios WHERE username = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

   
    if ($user && password_verify($password, $user['password_hash'])) {
       
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../../app/views/administracion_view.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>