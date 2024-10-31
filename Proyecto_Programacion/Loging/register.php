<?php
// Initialize variables
$error = '';
$success = '';

// Database connection
$host = 'localhost';
$dbname = 'login_system';
$user = 'root';
$pass = ''; // Assuming default XAMPP setup. Change if needed.

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Add your registration logic here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        
        if ($stmt->rowCount() > 0) {
            $error = "El nombre de usuario ya existe. Por favor, elige otro.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (username, password, created_at) VALUES (:username, :password, NOW())");
            $result = $stmt->execute(['username' => $username, 'password' => $hashed_password]);

            if ($result) {
                $success = "Usuario registrado exitosamente.";
            } else {
                $error = "Hubo un problema al registrar el usuario. Por favor, inténtalo de nuevo.";
            }
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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

        .register-form {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            text-align: center;
            color: #fff;
        }

        .register-form h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .register-form .form-group input {
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

        .register-form .form-group input::placeholder {
            color: #ccc;
        }

        .register-form .form-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        .register-form .btn {
            width: 100%;
            padding: 15px;
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

        .register-form .btn:hover {
            background: #2cbba5;
            transform: translateY(-3px);
        }

        .register-form .btn-secondary {
            margin-top: 10px;
            background: rgba(255, 255, 255, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 120px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }

        .alert {
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
    <div class="register-form">
        <div class="logo">
            <img src="CecyLibro.gif" alt="Logo">
        </div>
        <h2 class="text-center">Registro de Usuario</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <form method="post" action="register.php">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
            <div class="form-group">
                <a href="login.php" class="btn btn-secondary btn-block">¿Ya tienes cuenta? Iniciar Sesión</a>
            </div>
        </form>
    </div>
    <footer>© Colegio De Estudios Cientificos y Tecnologicos del Estado de Mexico Plantel Almoloya de Juarez 2024</footer>
</body>
</html>
