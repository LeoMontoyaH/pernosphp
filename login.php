<?php
session_start();
include 'conexion.php';

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'registro') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $password);
            if ($stmt->execute()) {
                $exito = "¡Cuenta creada con éxito! Ahora puedes iniciar sesión.";
            } else {
                $error = "El correo ya está registrado.";
            }
            $stmt->close();
        } elseif ($_POST['accion'] == 'login') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $nombre, $hashed_password);
                $stmt->fetch();
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['usuario_id'] = $id;
                    $_SESSION['usuario_nombre'] = $nombre;
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "No existe una cuenta con este correo.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - PERNOSCOL</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-container { max-width: 400px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid var(--border-color); }
        .auth-container h2 { color: var(--primary-blue); margin-bottom: 20px; font-size: 22px; text-align: center; }
        .auth-container form { display: flex; flex-direction: column; gap: 15px; }
        .auth-container input { padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-size: 14px; }
        .auth-container button { background: var(--accent-yellow); border: none; padding: 10px; font-weight: bold; border-radius: 4px; cursor: pointer; }
        .auth-container button:hover { background: var(--dark-yellow); }
        .msg-error { color: #e74c3c; font-size: 13px; text-align: center; }
        .msg-exito { color: #27ae60; font-size: 13px; text-align: center; }
        .back-home { display: block; text-align: center; margin-top: 15px; color: var(--primary-blue); text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Acceso a Mi Cuenta</h2>
        <?php if($error): ?><p class="msg-error"><?php echo $error; ?></p><?php endif; ?>
        <?php if($exito): ?><p class="msg-exito"><?php echo $exito; ?></p><?php endif; ?>

        <form method="POST">
            <h3>Iniciar Sesión</h3>
            <input type="hidden" name="accion" value="login">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border-color);">

        <form method="POST">
            <h3>Registrarse</h3>
            <input type="hidden" name="accion" value="registro">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Crear Cuenta</button>
        </form>

        <a href="index.php" class="back-home"><i class="fa-solid fa-arrow-left"></i> Volver al inicio</a>
    </div>
</body>
</html>