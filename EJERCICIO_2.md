# Ejercicio 2: Implementación de Vulnerabilidad SQL Injection

## 🎯 Objetivo Completado
Crear una aplicación web vulnerable a **SQL Injection** que permita acceder a noticias mediante parámetro GET.

## 🔓 Vulnerabilidad Implementada

### Código Vulnerable en `news.php`:
```php
// VULNERABILIDAD: Concatenación directa sin sanitización
$query = "SELECT id, title, body, datetime FROM blog WHERE id = " . $id;
$result = $pdo->query($query);
```

### ⚠️ Problema de Seguridad:
- **Sin validación** de entrada del parámetro `id`
- **Concatenación directa** del input del usuario en la consulta SQL
- **Sin prepared statements** ni escape de caracteres
- Permite **inyección de código SQL malicioso**

## 🧪 Pruebas de Funcionamiento

### URLs Válidas (Funcionan normalmente):
- `http://localhost/laboratorio-auditoria-web/news.php?id=1`
- `http://localhost/laboratorio-auditoria-web/news.php?id=2`  
- `http://localhost/laboratorio-auditoria-web/news.php?id=3`

### URLs Vulnerables (Preparadas para el ejercicio 3):
- `http://localhost/laboratorio-auditoria-web/news.php?id=1 OR 1=1`
- `http://localhost/laboratorio-auditoria-web/news.php?id=1 UNION SELECT 1,2,3,4`
- `http://localhost/laboratorio-auditoria-web/news.php?id=1; DROP TABLE blog;--`

## 📊 Datos de Prueba Disponibles

### Tabla `blog`:
| ID | Título |
|----|---------|
| 1  | Introducción a la Seguridad Web |
| 2  | Buenas Prácticas en Desarrollo PHP |
| 3  | Auditoría de Seguridad en Aplicaciones Web |

### Tabla `users`:
| ID | Email | Nombre |
|----|-------|---------|
| 1  | admin@example.com | Administrador |
| 2  | usuario1@example.com | Juan Pérez |
| 3  | usuario2@example.com | María García |

## 🔍 Diferencias con la Versión Segura

### ❌ Código Vulnerable (Actual):
```php
$query = "SELECT id, title, body, datetime FROM blog WHERE id = " . $id;
$result = $pdo->query($query);
```

### ✅ Código Seguro (Anterior):
```php
$stmt = $pdo->prepare("SELECT id, title, body, datetime FROM blog WHERE id = ?");
$stmt->execute([$id]);
```

## 🚨 Advertencias Importantes

⚠️ **SOLO PARA FINES EDUCATIVOS**
- Esta vulnerabilidad es **intencional** para aprendizaje
- **NO implementar** este código en entornos de producción
- Usar solo en **entornos controlados** de laboratorio
- El objetivo es **aprender** sobre vulnerabilidades web

## 🎓 Conceptos Clave Demostrados

1. **SQL Injection**: Inyección de código SQL malicioso
2. **Concatenación insegura**: Unir strings sin validación
3. **Falta de sanitización**: No limpiar input del usuario
4. **Ausencia de prepared statements**: No usar consultas parametrizadas

## 📝 Próximos Pasos

✅ **Ejercicio 2 COMPLETADO**
🔄 **Siguiente: Ejercicio 3** - Demostración manual de SQL Injection

---
**Estado:** ✅ Aplicación vulnerable implementada y lista para auditoría
