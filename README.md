# Laboratorio de Auditoría Web

Este proyecto es un laboratorio de práctica para aprender sobre vulnerabilidades web, específicamente SQL Injection.

## 🚀 Configuración del Entorno

### Prerrequisitos
- XAMPP (Apache + MySQL + PHP)
- Navegador web

### Instalación

1. **Instalar XAMPP**
   - Descargar desde [https://www.apachefriends.org/](https://www.apachefriends.org/)
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
│   └── database.php          # Configuración de base de datos
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

## 🎯 Ejercicios del Laboratorio

### ✅ Ejercicio 1 - Entorno Base (COMPLETADO)
- [x] Configuración de PHP, Apache y MySQL
- [x] Creación de tablas `users` y `blog`
- [x] Inserción de datos de prueba
- [x] Interfaz web básica con estilo moderno

### 🔄 Próximos Ejercicios
2. Implementar vulnerabilidad SQL Injection
3. Demostración de SQL Injection manual
4. Implementar Blind SQL Injection
5. Demostración de Blind SQLi
6. Auditoría con SQLMap y otras herramientas
7. Script automatizado de extracción
8. Corrección de vulnerabilidades

## 🎨 Características del Diseño

- **Estilo moderno y minimalista**
- **Colores pasteles** con gradientes suaves
- **Bordes redondeados** en todos los elementos
- **Efectos de transparencia** con backdrop-filter
- **Animaciones hover** suaves
- **Diseño responsivo**

## ⚠️ Advertencia de Seguridad

**Este proyecto contiene vulnerabilidades intencionadas para fines educativos.**
- Solo usar en entornos de desarrollo local
- No implementar en servidores de producción
- Destinado exclusivamente para aprendizaje de seguridad web

## 🗄️ Base de Datos

### Tabla `users`
| Campo    | Tipo         | Descripción           |
|----------|-------------|-----------------------|
| id       | INT (PK)     | Identificador único   |
| email    | VARCHAR(255) | Email del usuario     |
| name     | VARCHAR(255) | Nombre del usuario    |
| password | VARCHAR(255) | Contraseña del usuario|

### Tabla `blog`
| Campo    | Tipo         | Descripción           |
|----------|-------------|-----------------------|
| id       | INT (PK)     | Identificador único   |
| title    | VARCHAR(255) | Título del artículo   |
| body     | TEXT         | Contenido del artículo|
| datetime | DATETIME     | Fecha de publicación  |

## 📊 Datos de Prueba

**Usuarios:**
- admin@example.com - Administrador
- usuario1@example.com - Juan Pérez  
- usuario2@example.com - María García

**Artículos:**
- Introducción a la Seguridad Web
- Buenas Prácticas en Desarrollo PHP
- Auditoría de Seguridad en Aplicaciones Web
