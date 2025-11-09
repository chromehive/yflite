# YFlite by Chromehive

## Overview

YFlite is a lightweight PHP microframework designed for fast, modular, and reactive web apps using HTMX and AlpineJS. It is a designed to streamline the setup and configuration of web development environments to help you build and ship web apps faster. It provides a simple interface for initializing projects and includes a command-line tool for easy access.

## Installation

You can install the package with Composer (when published to Packagist or your own repository):

```bash
composer require chromehive/yflite:dev-main
```

## Usage

After installation, require Composer's autoloader and use the `Starter` class:

```php
<?php
require 'vendor/autoload.php';

use Chromehive\YFlite\Starter;

$starter = new Starter();
$starter->initialize();
```

## Examples

See `examples/quickstart.php` for a minimal example of using the DevKit in a project.

## Running Tests

This project uses PHPUnit for tests. Install dev dependencies and run tests with Composer:

```bash
composer install --dev
vendor/bin/phpunit
```

## Contributing

Please see `CONTRIBUTING.md` for contribution guidelines.

## License

This project is licensed under the MIT License — see the `LICENSE` file.

## Developer Quickstart

After installing via Composer, the package provides:

- `public/` directory with example web root and assets to get started locally (copy or symlink this to your web server's root if desired)
- Example `config.php` and `path.php` files for typical development use.
- `config.php.example` and `path.php.example` templates — copy and configure for your own environment:

```bash
cp config.php.example config.php
cp path.php.example path.php
```

### Running the CLI

You can use the DevKit CLI tool with:

```bash
php yflite
```

This provides commands for scaffolding pages, CRUD, models, and routes. Run the binary with no arguments to see available commands and usage examples.

### Localhost Dev Environment

Copy the included `public/` directory into your web root, and make sure `config.php` and `path.php` are in the root of your project. Adjust as needed for your server stack:

- Apache/Nginx: set web root to `public/`
- Start PHP built-in server:
  ```bash
  php -S localhost:8000 -t public
  ```
