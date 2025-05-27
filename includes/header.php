<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio de Auditoría Web</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e8f4fd 0%, #f0f8ff 100%);
            min-height: 100vh;
            color: #2c3e50;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #3498db;
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 1.1em;
        }

        .blog-grid {
            display: grid;
            gap: 25px;
        }

        .blog-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.95);
        }

        .blog-title {
            color: #2c3e50;
            font-size: 1.4em;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .blog-title a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        .blog-title a:hover {
            color: #3498db;
        }

        .blog-excerpt {
            color: #5a6c7d;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .blog-meta {
            color: #95a5a6;
            font-size: 0.9em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .read-more {
            background: linear-gradient(135deg, #74b9ff 0%, #3498db 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .read-more:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(116, 185, 255, 0.4);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 30px;
            justify-content: center;
        }

        .navbar a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            color: #3498db;
            background: rgba(116, 185, 255, 0.1);
        }

        .alert {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🔒 Laboratorio de Auditoría Web</h1>
            <p class="subtitle">Entorno de práctica para pruebas de seguridad</p>
        </header>

        <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="news.php">Noticias</a></li>
                <li><a href="users.php">Usuarios</a></li>
            </ul>
        </nav>
