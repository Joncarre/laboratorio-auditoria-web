<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio de Auditoría Web</title>    <style>        :root {
            --teal: #029990;
            --coral: #d87878;
            --purple: #8b5cf6;
            --sky-blue: #87ceeb;
            --warm-gray: #bfb6b0;
            --cream: #e9d7a5;
            --off-white: #f0efea;
            --text-primary: #2c3e50;
            --text-secondary: #5a6c7d;
            --background-gradient: linear-gradient(135deg, 
                rgba(240, 239, 234, 0.8) 0%, 
                rgba(233, 215, 165, 0.3) 25%,
                rgba(191, 182, 176, 0.2) 75%,
                rgba(135, 206, 235, 0.15) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-gradient), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-primary);
            backdrop-filter: blur(1px);
        }        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }        header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 12px 40px rgba(2, 153, 144, 0.15);
            text-align: center;
            border: 1px solid rgba(135, 206, 235, 0.3);
            position: relative;
            overflow: hidden;
        }        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--teal);
            border-radius: 25px 25px 0 0;
        }h1 {
            color: var(--text-primary);
            font-size: 2.8em;
            margin-bottom: 10px;
            font-weight: 300;
            text-shadow: 0 2px 4px rgba(2, 153, 144, 0.1);
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.2em;
            opacity: 0.8;
        }        .blog-grid {
            display: grid;
            gap: 30px;
        }        .blog-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(2, 153, 144, 0.12);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(135, 206, 235, 0.3);
            position: relative;
            overflow: hidden;
        }        .blog-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--teal);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(2, 153, 144, 0.2);
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(216, 120, 120, 0.4);
        }

        .blog-card:hover::before {
            opacity: 1;
        }        .blog-title {
            color: var(--text-primary);
            font-size: 1.5em;
            margin-bottom: 15px;
            font-weight: 600;
        }        .blog-title a {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }        .blog-title a:hover {
            color: var(--teal);
            transform: translateX(5px);
        }

        .blog-excerpt {
            color: rgba(44, 62, 80, 0.8);
            line-height: 1.7;
            margin-bottom: 20px;
            font-size: 1.05em;
        }

        .blog-meta {
            color: rgba(90, 108, 125, 0.8);
            font-size: 0.95em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
        }        .read-more {
            background: var(--teal);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 0.95em;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(2, 153, 144, 0.3);
        }

        .read-more:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 25px rgba(2, 153, 144, 0.4);
            background: var(--coral);
        }.navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 18px 30px;
            margin-bottom: 25px;
            box-shadow: 0 6px 25px rgba(2, 153, 144, 0.1);
            border: 1px solid rgba(135, 206, 235, 0.3);
            position: relative;
        }        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(233, 215, 165, 0.1);
            border-radius: 20px;
            pointer-events: none;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 35px;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .navbar a {
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 15px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }        .navbar a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--sky-blue);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 15px;
        }

        .navbar a:hover {
            color: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 153, 144, 0.2);
        }

        .navbar a:hover::before {
            opacity: 1;
        }

        .navbar a span {
            position: relative;
            z-index: 1;
        }        .alert {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(216, 120, 120, 0.4);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            color: var(--coral);
            box-shadow: 0 6px 20px rgba(216, 120, 120, 0.15);
            font-weight: 500;
        }

        /* Efectos adicionales de glassmorphism */
        .glass-effect {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }        /* Animaciones sutiles */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Scroll suave */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>    <div class="container">        <header>
            <h1>Prácticas de Iniciación Profesional</h1>
            <p class="subtitle">Laboratorio de auditoría web</p>
        </header>

        <nav class="navbar">
            <ul>
                <li><a href="index.php"><span>Inicio</span></a></li>
                <li><a href="news.php"><span>Noticias</span></a></li>
                <li><a href="users.php"><span>Usuarios</span></a></li>
            </ul>
        </nav>
