# Laboratorio de Auditoría Web - Instrucciones de Configuración

## 📋 Configuración Paso a Paso

### 1. Instalar XAMPP
1. Descargar XAMPP desde: https://www.apachefriends.org/
2. Ejecutar el instalador y seguir las instrucciones
3. Iniciar el Panel de Control de XAMPP
4. Activar los servicios **Apache** y **MySQL**

### 2. Configurar el Proyecto
1. Copiar toda la carpeta del proyecto a `C:\xampp\htdocs\`
2. La ruta final debe ser: `C:\xampp\htdocs\laboratorio-auditoria-web\`

### 3. Configurar la Base de Datos
1. Abrir navegador y ir a: http://localhost/phpmyadmin
2. Hacer clic en "SQL" en la parte superior
3. Copiar y pegar todo el contenido del archivo `database/setup.sql`
4. Hacer clic en "Continuar" para ejecutar el script

### 4. Verificar la Instalación
1. Abrir navegador y ir a: http://localhost/laboratorio-auditoria-web
2. Deberías ver la página principal con 3 artículos
3. Probar hacer clic en "Leer más" en cualquier artículo
4. Verificar que la URL cambie a algo como: http://localhost/laboratorio-auditoria-web/news.php?id=1

### 5. Verificar la Base de Datos
En phpMyAdmin, deberías ver:
- Base de datos: `auditoria_web`
- Tabla `users` con 3 registros
- Tabla `blog` con 3 registros

## ✅ Estado Actual: Ejercicio 1 Completado

El entorno base está configurado con:
- ✅ PHP, Apache y MySQL funcionando
- ✅ Base de datos `auditoria_web` creada
- ✅ Tabla `users` con 3 usuarios de prueba
- ✅ Tabla `blog` con 3 artículos de prueba
- ✅ Interfaz web moderna y funcional
- ✅ Página de noticias que acepta parámetro ID vía GET

## 🎯 Próximo Paso: Ejercicio 2
En el siguiente ejercicio haremos la aplicación vulnerable a SQL Injection modificando el archivo `news.php`.
