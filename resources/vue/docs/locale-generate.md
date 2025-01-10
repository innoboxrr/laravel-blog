# Locale Translation Script

This README explains how to use the Python script `locale-generate.py` to extract, manage, and translate strings in your project for localization purposes. The script uses Google Translate API for automatic translations.

---

## Features

1. Extracts strings wrapped in `__blog('...')` from your project files.
2. Supports custom exclusions for directories like `node_modules`, `docs`, etc.
3. Generates locale JSON files for specified languages.
4. Automatically translates strings using Google Translate if requested.
5. Handles empty strings and avoids duplicates.

---

## Installation

### Prerequisites

1. Python 3.8 or later.
2. `pip` for managing dependencies.
3. A Google Translate API key.

### Setup

1. Clone or navigate to your project directory.
2. Install required dependencies:
   ```bash
   pip install requests python-dotenv
   ```
3. Create a `.env` file in the root of your project and add your Google Translate API key:
   ```plaintext
   GOOGLE_TRANSLATE_KEY=your-google-translate-api-key
   ```

---

## Usage

### Script Command

```bash
python python/locale-generate.py <languages> [options]
```

### Parameters

- `<languages>`: Space-separated list of target languages (e.g., `es en fr`).
- `-t, --translate`: Automatically translates strings using the Google Translate API.
- `-f, --file`: Specify a file or directory to search for `__blog('...')` strings. Defaults to the project root.

### Examples

#### 1. Generate locales for Spanish, English, and French with translations:
```bash
python python/locale-generate.py es en fr -t
```

#### 2. Analyze a specific file:
```bash
python python/locale-generate.py es -f components/BlogApp.vue
```

#### 3. Analyze a directory excluding default ignored directories:
```bash
python python/locale-generate.py es en fr
```

---

## Directory Structure

Your project directory should look like this:

```
project-root
├── locales
│   ├── es.json
│   ├── en.json
│   ├── fr.json
├── python
│   ├── locale-generate.py
├── .env
```

---

## Generated Files

For each specified language, the script creates or updates a JSON file in the `locales` directory. Example content for `es.json`:

```json
{
    "Close sidebar": "Cerrar barra lateral",
    "Categories": "Categorías"
}
```

---

## Notes

1. **Exclusions**:
   - The script excludes directories like `node_modules`, `docs`, `routes`, and `store` by default. You can modify this behavior by updating the `EXCLUDED_DIRS` variable in the script.

2. **Empty Strings**:
   - The script skips over empty strings to avoid unnecessary processing.

3. **Translations**:
   - If the `-t` flag is not used, untranslated strings will be left as empty values in the JSON file.

4. **Duplicate Handling**:
   - The script removes duplicate strings before processing.

---

## Troubleshooting

### Error: `Invalid Value`

- Ensure the `GOOGLE_TRANSLATE_KEY` in your `.env` file is correct.
- Check that the languages specified are valid (e.g., `es`, `en`, `fr`).

### No Strings Found

- Verify that your project contains `__blog('...')` strings.
- Check the file or directory specified with the `-f` flag.

---

## Contributing

If you encounter issues or have suggestions, feel free to submit a pull request or open an issue in the repository.

---

## License

This script is open source and available under the MIT License.

