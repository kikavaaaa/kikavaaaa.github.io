<?php
session_start();
require 'config.php';  // Asegúrate de que este archivo esté en la misma carpeta o usa la ruta correcta

$error = null;

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta para buscar al usuario
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Recuperar el usuario de la base de datos
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        // Autenticación exitosa
        $_SESSION['user_id'] = $user['id'];  // Se guarda el ID del usuario en la sesión
        header("Location: ../Principal/index.html");  // Redirigir a la página deseada
        exit();
    } else {
        // Autenticación fallida
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #6f2cfb, #34d1bf);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        .login-form {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            text-align: center;
            color: #fff;
        }

        .login-form h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-form .form-group input {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease;
        }

        .login-form .form-group input::placeholder {
            color: #ccc;
        }

        .login-form .form-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        .login-form .btn {
            width: 100%;
            padding: 20px;
            border: none;
            border-radius: 10px;
            background: #34d1bf;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(52, 209, 191, 0.4);
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .login-form .btn:hover {
            background: #2cbba5;
            transform: translateY(-3px);
        }

        .login-form .btn-secondary {
            
            background: rgba(255, 255, 255, 0.3);
            margin-bottom: 80;
        }

        .logo img {
            max-width: 120px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }

        .alert-danger {
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        footer {
    margin-top: 40px;
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    text-align: center;
    padding: 10px 0;
    background-color: rgba(0, 0, 0, 0.2);  /* Fondo sutil que armonice con el diseño */
    border-top: 1px solid rgba(255, 255, 255, 0.3); /* Línea superior para separar el footer */
    position: absolute;
    bottom: 0;
    width: 100%;
    left: 0;
}
        </style>
</head>
<body>
    <div class="login-form">
        <div class="logo">
            <img src="CecyLibro.gif" alt="Logo">
        </div>
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </div>
        </form>
        <div class="form-group">
            <a href="register.php" class="btn btn-secondary btn-block">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
    <footer>© Colegio De Estudios Cientificos y Tecnologicos del Estado de Mexico Plantel Almoloya de Juarez 2024</footer>
</body>
</html>