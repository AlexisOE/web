<?php
// Conexión (mejor usar el archivo conexion.php)
require_once 'conexion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $email = $conexion->real_escape_string($_POST['email']);
    $password = hash('sha256', $_POST['password']); // Hash básico
    
    try {
        // Verificar si el email ya existe
        $check = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        
        if ($check->num_rows > 0) {
            $error = "El email ya está registrado";
        } else {
            // Insertar nuevo usuario
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $password);
            
            if ($stmt->execute()) {
                $success = "¡Registro exitoso! Ahora puedes iniciar sesión";
                // Opcional: Redirigir después de 3 segundos
                header("refresh:3;url=login.php");
            } else {
                $error = "Error al registrar: " . $stmt->error;
            }
            
            $stmt->close();
        }
        $check->close();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
    
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - TechFounders</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos iguales a los de login.php */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo {
            margin-bottom: 1.5rem;
        }
        .logo i {
            font-size: 3rem;
            color: #4361ee;
        }
        .logo h1 {
            font-size: 1.8rem;
            margin-top: 0.5rem;
            color: #1a1a2e;
        }
        .slogan {
            color: #666;
            margin-bottom: 2rem;
            font-weight: 300;
        }
        .input-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        .input-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: #4361ee;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #3a0ca3;
        }
        .login-footer {
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        .login-footer a {
            color: #4361ee;
            text-decoration: none;
        }
        .error-message {
            color: #ff4444;
            margin-bottom: 1rem;
            text-align: center;
        }
        .success-message {
            color: #00C851;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-network-wired"></i>
            <h1>TechFounders Network</h1>
        </div>
        <p class="slogan">Únete a nuestra comunidad</p>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form action="registro.php" method="POST">
            <div class="input-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Registrarse</button>
        </form>

        <div class="login-footer">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>