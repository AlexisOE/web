<?php
session_start();
require_once 'conexion.php'; // Incluye el archivo de conexión
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Consulta preparada para seguridad
    $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        // Verificar contraseña (asumiendo que usaste SHA2 en la BD)
        if (hash('sha256', $password) === $usuario['password']) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nombre'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
    
    $stmt->close();
    $conexion->close(); // Cierra la conexión
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFounders Network | Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3a0ca3;
            --accent: #4cc9f0;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--accent), var(--primary-light));
            border-radius: 50%;
            opacity: 0.4;
            z-index: 0;
        }
        
        .login-card::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            opacity: 0.4;
            z-index: 0;
        }
        
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }
        
        .logo i {
            font-size: 3rem;
            color: var(--primary);
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }
        
        .slogan {
            color: var(--gray);
            margin-bottom: 2rem;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .error-message {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger);
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--danger);
            text-align: left;
            position: relative;
            z-index: 1;
        }
        
        form {
            position: relative;
            z-index: 1;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
            text-align: left;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e1e5eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
        }
        
        .input-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }
        
        .input-group i {
            position: absolute;
            right: 15px;
            top: 42px;
            color: var(--gray);
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, var(--primary-light), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .login-footer {
            margin-top: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .login-footer a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .login-footer p {
            margin-top: 1rem;
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .social-login {
            margin-top: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .social-login p {
            position: relative;
            text-align: center;
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background-color: #e1e5eb;
        }
        
        .social-login p::before {
            left: 0;
        }
        
        .social-login p::after {
            right: 0;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
        
        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        
        .social-icon i {
            font-size: 1.2rem;
        }
        
        .social-icon.google i {
            color: #DB4437;
        }
        
        .social-icon.linkedin i {
            color: #0077B5;
        }
        
        .social-icon.github i {
            color: #333;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .logo i {
                font-size: 2.5rem;
            }
            
            .logo h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-network-wired"></i>
            <h1>TechFounders</h1>
        </div>
        <p class="slogan">Conecta con la comunidad que impulsa tu startup</p>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                <i class="far fa-envelope"></i>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="********" required>
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit" class="btn-login">
                Iniciar Sesión <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer">
            <a href="#"><i class="fas fa-key"></i> ¿Olvidaste tu contraseña?</a>
            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
        
        <div class="social-login">
            <p>O inicia sesión con</p>
            <div class="social-icons">
                <a href="#" class="social-icon google">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="social-icon linkedin">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="social-icon github">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </div>
    </div>
</body>
</html>