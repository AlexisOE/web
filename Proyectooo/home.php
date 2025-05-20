<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFounders Network | Inicio</title>
    
    <!-- Tipografía y Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos -->
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        header.main-header {
            background: white;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .logo h1 {
            font-size: 1.4rem;
            font-weight: 600;
        }

        nav.main-nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
        }

        .main-nav a {
            text-decoration: none;
            color: var(--gray);
            font-weight: 500;
            transition: color 0.3s;
        }

        .main-nav a:hover,
        .main-nav a.active {
            color: var(--primary);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-notification {
            color: var(--gray);
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .btn-notification:hover {
            color: var(--primary);
        }

        .user-profile img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        /* Hero */
        .hero {
            padding: 4rem 0 2rem;
            text-align: center;
        }

        .hero h2 {
            font-size: 2.4rem;
            margin-bottom: 1rem;
        }

        .hero h2 span {
            color: var(--primary);
        }

        .hero p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .feature-card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 1rem;
            color: #555;
        }

        .btn-register {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1.2rem;
            background: var(--primary);
            color: white;
            border-radius: 6px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-register:hover {
            background: var(--secondary);
        }

        /* Events */
        .upcoming-events {
            margin: 4rem 0;
        }

        .upcoming-events h3 {
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .upcoming-events h3 i {
            color: var(--primary);
        }

        .event-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .event-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .event-card:hover {
            transform: translateY(-4px);
        }

        .event-card h4 {
            margin-bottom: 0.6rem;
            color: var(--dark);
        }

        .event-card p {
            color: #666;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Footer */
        .main-footer {
            text-align: center;
            padding: 1.5rem 0;
            background: var(--dark);
            color: white;
            margin-top: 4rem;
        }

        /* Logout button */
        .btn-logout {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 0.4rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            background-color: var(--primary);
            color: white;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <i class="fas fa-network-wired"></i>
                <h1>TechFounders</h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="home.php" class="active">Inicio</a></li>
                    <li><a href="miembros.html">Miembros</a></li>
                    <li><a href="eventos.html">Eventos</a></li>
                    <li><a href="recursos.html">Recursos</a></li>
                    <li><a href="foro.html">Foro</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <a href="#" class="btn-notification"><i class="fas fa-bell"></i></a>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="Perfil">
                </div>
                <a href="logout.php" class="btn-logout">Cerrar sesión</a>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Bienvenido de vuelta, <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span> 👋</h2>
            <p>Descubre las últimas oportunidades en la comunidad tech.</p>
        </section>

        <section class="features">
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Conecta</h3>
                <p>Encuentra cofundadores, mentores o inversores.</p>
                <a href="miembros.html" class="btn-register">Explorar</a>
            </div>
            <div class="feature-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Eventos</h3>
                <p>Webinars y meetups exclusivos.</p>
                <a href="eventos.html" class="btn-register">Ver eventos</a>
            </div>
            <div class="feature-card">
                <i class="fas fa-briefcase"></i>
                <h3>Oportunidades</h3>
                <p>Proyectos y vacantes en startups.</p>
                <a href="recursos.html" class="btn-register">Buscar</a>
            </div>
        </section>

        <section class="upcoming-events">
            <h3><i class="fas fa-calendar-alt"></i> Próximos Eventos</h3>
            <div class="event-list">
                <div class="event-card">
                    <h4>Webinar: Financiamiento para Startups</h4>
                    <p><i class="far fa-clock"></i> 15 Mayo, 18:00 (GMT-5)</p>
                    <p><i class="fas fa-user-tie"></i> Invitado: Javier López (500 Startups)</p>
                    <a href="https://www.eventbrite.com" target="_blank" class="btn-register">Registrarse</a>
                </div>
                <div class="event-card">
                    <h4>Hackathon Global Tech 2024</h4>
                    <p><i class="far fa-clock"></i> 25 Mayo, 09:00 (GMT-5)</p>
                    <p><i class="fas fa-map-marker-alt"></i> Modalidad: Virtual</p>
                    <a href="https://www.eventbrite.com" target="_blank" class="btn-register">Registrarse</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>© 2024 TechFounders Network. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
