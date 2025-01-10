import os
import re
import json
import requests
from dotenv import load_dotenv
import argparse

# Use: python python/locale-generate.py es en fr -t

# Ruta raíz del proyecto
BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), '..'))

# Cargar variables de entorno desde .env
load_dotenv(os.path.join(BASE_DIR, '.env'))
GOOGLE_TRANSLATE_KEY = os.getenv("GOOGLE_TRANSLATE_KEY")
GOOGLE_TRANSLATE_URL = "https://translation.googleapis.com/language/translate/v2"

# Directorios a excluir
EXCLUDED_DIRS = {'docs', 'node_modules'}

# Función para extraer todas las cadenas __blog('') de un archivo
def extract_strings(file_path):
    with open(file_path, 'r', encoding='utf-8') as file:
        content = file.read()
    matches = re.findall(r"__blog\(['\"](.*?)['\"]\)", content)
    if matches:
        print(f"[INFO] Cadenas encontradas en {file_path}: {matches}")
    return matches

# Función para recorrer un directorio y extraer cadenas
def extract_strings_from_directory(directory):
    strings = []
    print(f"[INFO] Analizando directorio: {directory}")
    for root, dirs, files in os.walk(directory):
        # Excluir directorios específicos
        dirs[:] = [d for d in dirs if d not in EXCLUDED_DIRS]
        for file in files:
            if file.endswith(('.js', '.vue', '.html', '.py')):
                file_path = os.path.join(root, file)
                strings.extend(extract_strings(file_path))
    return strings

# Función para traducir cadenas con la API de Google Translate
def translate_string(text, target_lang):
    if not GOOGLE_TRANSLATE_KEY:
        raise ValueError("Google Translate API key no encontrada en .env")

    if not text.strip():  # Evitar traducir cadenas vacías
        return text

    response = requests.post(
        GOOGLE_TRANSLATE_URL,
        params={"key": GOOGLE_TRANSLATE_KEY},
        json={"q": text, "target": target_lang}
    )

    if response.status_code == 200:
        result = response.json()
        return result['data']['translations'][0]['translatedText']
    else:
        raise Exception(f"Error en la API de traducción: {response.text}")

# Función para generar un archivo JSON de locales
def generate_locale_json(strings, lang, translate):
    locales_dir = os.path.join(BASE_DIR, 'locales')
    locale_path = os.path.join(locales_dir, f"{lang}.json")

    # Cargar traducciones existentes si el archivo ya existe
    if os.path.exists(locale_path):
        with open(locale_path, 'r', encoding='utf-8') as file:
            translations = json.load(file)
    else:
        translations = {}

    # Añadir o traducir cadenas
    for string in strings:
        if string not in translations:
            translations[string] = translate_string(string, lang) if translate else ""

    # Guardar el archivo actualizado
    os.makedirs(locales_dir, exist_ok=True)
    with open(locale_path, 'w', encoding='utf-8') as file:
        json.dump(translations, file, ensure_ascii=False, indent=4)

    print(f"[INFO] Archivo de locales generado: {locale_path}")

# Script principal
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Generar y gestionar archivos de locales para traducciones de Blog.")
    parser.add_argument("languages", nargs='+', help="Idiomas objetivo (por ejemplo, es en fr)")
    parser.add_argument("-t", "--translate", action="store_true", help="Traducir automáticamente las cadenas con la API de Google Translate")
    parser.add_argument("-f", "--file", default=BASE_DIR, help="Archivo o directorio a buscar para cadenas __blog")

    args = parser.parse_args()

    # Extraer cadenas
    strings = []
    if os.path.isfile(args.file):
        print(f"[INFO] Analizando archivo: {args.file}")
        strings = extract_strings(args.file)
    elif os.path.isdir(args.file):
        strings = extract_strings_from_directory(args.file)
    else:
        print("[ERROR] Archivo o directorio no válido especificado.")
        exit(1)

    strings = list(set(strings))  # Eliminar duplicados
    if not strings:
        print("[WARNING] No se encontraron cadenas para traducir.")
        exit(0)

    # Generar archivos de locales para cada idioma
    for lang in args.languages:
        generate_locale_json(strings, lang, args.translate)
