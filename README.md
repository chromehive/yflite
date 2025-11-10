# YFlite CLI

A PHP scaffolding tool for rapid application development using YFlite, a lightweight PHP microframework.

## Features

- Generate pages with layout support
- CRUD scaffolding with model, controller and views
- Tailwind CSS styled templates
- Form field generation with validation
- Route management
- Models with basic database operations

## Installation

You can install it globally on your computer if you have the PHP environment with composer installed.

```bash
composer global require chromehive/yflite:dev-main
```

## Developer Quickstart

After installing via Composer, run the command below to see if YFlite installed properly

```bash
yflite -v
```

Is it available to you? Then, let's open a fresh directory and run this code once to set up your development project

```bash
yflite new
```

## Usage

Start the development server using:

```bash
yflite start
```

## Initialised Folder/File Structure

```bash
yflite/
├── controllers/
│   └── public.php
├── models/
├── middlewares/
├── vendor/
├── public/              # Server entry point
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   ├── index.php
│   ├── robots.txt
│   └── sitemap.txt
├── views/
│   ├── components/
│   ├── layouts/
│   │   ├── main.php
│   │   └── dashboard.php
│   └── pages/
│       ├── _404.php
│       └── home.php
├── bootstrap.php
├── helpers.php
├── config.php  # Modifiable Configurations File
├── composer.json
├── composer.lock
└── path.php    # Modifiable Path Constants File
```

The YFlite CLI provides several generators:

### Generate Pages

```bash
# Single page
yflite make:page dashboard

# Multiple pages
yflite make:page home about contact

# Nested page (creates folders+files)
yflite make:page policies settings/profile settings/notifications
```

### Generate CRUD

```bash
# Basic CRUD
yflite make:crud Product

# CRUD with fields
yflite make:crud Product --fields="title:string,price:decimal,description:text"
```

### Generate Model

```bash
# Basic model
yflite make:model User

# Model with custom table
yflite make:model User --table=users
```

### Add Route

```bash
yflite make:route GET /api/data api:data
```

## Contributing

Please see `CONTRIBUTING.md` for contribution guidelines.

## License

This project is licensed under the MIT License — see the `LICENSE` file.
