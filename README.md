# YFlite CLI

A PHP scaffolding tool for rapid application development using YFlite, a lightweight PHP microframework.

## Features

- Generate pages with layout support
- CRUD scaffolding with model, controller and views
- Form field generation with validation
- Route management
- Models with basic database operations

## Installation

You can install it globally on your computer if you have the PHP environment with composer installed.

```bash
composer global require chromehive/yflite
```

## Developer Quickstart

After installing via Composer, run the command below to see if YFlite installed properly

```bash
yflite -v
```

Does it show you the version number? Then, YFlite is available to you? Now, let's open or create a fresh directory and run this code in the terminal for that directory once to set up your development project.

```bash
yflite new
```

If you want to have the project initialise in a fresh project directory and run:

```bash
yflite new <app-name>
```

For example: `yflite new fire-app-project`

## Usage

Start the development server using:

```bash
yflite start
```

To compile your production-ready build:

```bash
yflite build <build-folder>
```

If the name of the build folder is not specified, the default `/dist` folder will be created automatically in the project root directory.

## Initialised Folder/File Structure

```bash
<your-app-name>/
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

## Route Regex Examples for URI Parameters

Here are a few essential regex patterns and their aliases you may need if you wish to validate URI parameters from client. Feel free to make your own patterns if necessary.

| Use Case             | Pattern                                                          | Example URI                                  |
| -------------------- | ---------------------------------------------------------------- | -------------------------------------------- |
| Number or Numeric ID | `(\d+)`                                                          | `/users/42`                                  |
| Slug                 | `([a-zA-Z0-9-_]+)`                                               | `/posts/hello-world`                         |
| Username             | `([a-zA-Z0-9_]+)`                                                | `/profile/hello123_`                         |
| UUID                 | `([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})` | `/chat/123e4567-e89b-12d3-a456-426614174000` |
| Y-m-D Date           | `([0-9]{4}-[0-9]{2}-[0-9]{2})`                                   | `/orders/2025-11-09`                         |
| Alpha word           | `([A-Za-z]+)`                                                    | `/category/books`                            |
| Alphanumeric         | `([A-Za-z0-9]+)`                                                 | `/categories/101Books`                       |
| Catch-all (no slash) | `([^/]+)`                                                        | `/anything/value`                            |

Example Use of Default Regex Patterns or Aliases Available

```php
return [
    ['GET', '/users/(\d+)', 'users:users_show'],
    ['GET', '/posts/([a-zA-Z0-9-_]+)', 'blog:post_view'],
    ['GET', '/@([a-zA-Z0-9_]+)', 'user:profile'],
];
```

Normal route format:

```php
    ['METHOD', '/route', 'file:function'],
```

Routes with middleware(s):

```php
    ['METHOD', '/route', 'file:function', 'mwfile1:mwfunc1, mwfile2:mwfunc2'],
```

### Last Updated: November 12, 2025


