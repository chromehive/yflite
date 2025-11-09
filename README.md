# YFlite CLI

A PHP scaffolding tool for rapid application development.

## Features

- Generate pages with layout support
- CRUD scaffolding with model, controller and views
- Tailwind CSS styled templates
- Form field generation with validation
- Route management
- Models with basic database operations

## Installation

```bash
composer require chromehive/yflite:dev-main
```

## Usage

The YFlite CLI provides several generators:

### Generate Pages

```bash
# Single page
php vendor/bin/yflite make:page dashboard

# Multiple pages
php vendor/bin/yflite make:page home about contact

# Nested page
php vendor/bin/yflite make:page settings/profile
```

### Generate CRUD

```bash
# Basic CRUD
php vendor/bin/yflite make:crud Product

# CRUD with fields
php vendor/bin/yflite make:crud Product --fields="title:string,price:decimal,description:text"
```

### Generate Model

```bash
# Basic model
php vendor/bin/yflite make:model User

# Model with custom table
php vendor/bin/yflite make:model User --table=users
```

### Add Route

```bash
php vendor/bin/yflite make:route GET /api/data api:data
```

## License

MIT

