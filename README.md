# Laboratorio de auditoría web

Repositorio donde ir desarrollando el laboratorio de auditoría web correspondiente a la Práctica 2 de la asignatura Prácticas de Iniciación Profesional.

## Configuración del Entorno

### Prerrequisitos
- XAMPP (Apache + MySQL + PHP)
- Navegador web

### Instalación

1. **Instalar XAMPP**
   - Descargar desde [https://www.apachefriends.org/](https://www.apachefriends.org)
   - Instalar y ejecutar Apache y MySQL

2. **Configurar el proyecto**
   ```bash
   # Copiar el proyecto a la carpeta htdocs de XAMPP
   # Normalmente en: C:\xampp\htdocs\laboratorio-auditoria-web
   ```

3. **Configurar la base de datos**
   - Abrir phpMyAdmin en [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Ejecutar el script `database/setup.sql`

4. **Acceder a la aplicación**
   - Abrir [http://localhost/laboratorio-auditoria-web](http://localhost/laboratorio-auditoria-web)

## 📁 Estructura del Proyecto

```
laboratorio-auditoria-web/
├── config/
│   └── database.php         # Configuración de base de datos
├── database/
│   └── setup.sql            # Script de configuración de BD
├── includes/
│   ├── header.php           # Cabecera común
│   └── footer.php           # Pie común
├── index.php                # Página principal
├── news.php                 # Página de noticias (vulnerable)
├── users.php                # Página de usuarios
└── README.md
```


## 🗄️ Base de Datos

### Tabla `users`
| Campo    | Tipo         | Descripción           |
|----------|--------------|-----------------------|
| id       | INT (PK)     | Identificador único   |
| email    | VARCHAR(255) | Email del usuario     |
| name     | VARCHAR(255) | Nombre del usuario    |
| password | VARCHAR(255) | Contraseña del usuario|

### Tabla `blog`
| Campo    | Tipo         | Descripción           |
|----------|--------------|-----------------------|
| id       | INT (PK)     | Identificador único   |
| title    | VARCHAR(255) | Título del artículo   |
| body     | TEXT         | Contenido del artículo|
| datetime | DATETIME     | Fecha de publicación  |

## 📊 Datos de prueba utilizados

**Usuarios:**
- admin@example.com - Administrador
- usuario1@example.com - Juan Pérez  
- usuario2@example.com - María García

**Artículos:**
- Introducción a la Seguridad Web
- Buenas Prácticas en Desarrollo PHP
- Auditoría de Seguridad en Aplicaciones Web
