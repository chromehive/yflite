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

If you used `yflite new <app-name>` to initialise your project, then you need to switch to that directory first.

```bash
cd <app-name>
yflite start
```

To compile your production-ready build:

```bash
yflite build --dest=<project-build-name>
```

To compile your production-ready build in zip format:

```bash
yflite build --dest=<project-build-name> --zip
```

If the name of the build folder is omitted along with the `--dest` flag, the default `/dist` folder or `dist.zip` will be created automatically in the project root directory.

## Typical Folder/File Structure

```bash
<your-app-name>/
├── app/
│   ├── _core/
│   ├── configs/
│   │   ├── index.php  # Modifiable Configurations File
│   │   └── route_aliases.php
│   ├── controllers/
│   │   └── public.php  # Controls some non-dashboard pages
│   ├── helpers/
│   ├── middlewares/
│   ├── models/
│   ├── routes/
│   └── views/
│       ├── components/
│       ├── layouts/
│       │   ├── dashboard.php
│       │   └── main.php
│       └── pages/
│           ├── 404.php
│           └── home.php
├── vendor/
├── public/
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   ├── index.php    # Server entry point
│   ├── robots.txt
│   └── sitemap.txt
├── storage/
│   ├── cache/
│   └── logs/
├── tests/
├── composer.json
├── path.php    # Modifiable Path Constants File
└── README.md
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

Here are a few essential regex patterns and their aliases you may need if you wish to validate URI parameters from client. Feel free to make your own patterns if necessary. You can also add custom aliases by define your patterns as accurately as possible in the `/configs/route_aliases.php`.

| Use Case             | Alias       | Pattern                                                          | Example URI                                  |
| -------------------- | ----------- | ---------------------------------------------------------------- | -------------------------------------------- |
| Number or Numeric ID | :id or :int | `(\d+)`                                                          | `/users/42`                                  |
| Slug                 | :slug       | `([a-zA-Z0-9-_]+)`                                               | `/posts/hello-world`                         |
| Username             | :username   | `([a-zA-Z0-9_]+)`                                                | `/profile/hello123_`                         |
| UUID                 | :uuid       | `([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})` | `/chat/123e4567-e89b-12d3-a456-426614174000` |
| Y-m-D Date           | :date       | `([0-9]{4}-[0-9]{2}-[0-9]{2})`                                   | `/orders/2025-11-09`                         |
| Alpha word           | :alpha      | `([A-Za-z]+)`                                                    | `/category/books`                            |
| Alphanumeric         | :alphanum   | `([A-Za-z0-9]+)`                                                 | `/category/101Books`                         |
| Catch-all (no slash) | :any        | `([^/]+)`                                                        | `/anything/value`                            |

Example Use of Default Regex Patterns or Aliases Available.

```php
return [
    ['GET', '/posts/:slug', 'blog:post_view'],
    ['GET', '/@([a-zA-Z0-9_]+)', 'user:profile'],
];
```

Normal route format:

```php
    ['METHOD', '/route', 'ctrlrfile:function'],
```

Routes with middleware(s):

```php
    ['METHOD', '/route', 'ctrlrfile:function', 'mwfile1:mwfunc1, mwfile2:mwfunc2'],
```

## Only In Versions >= v1.4.0

Our YUI component library is available to you. Just call the yui() php function, pass the name of the component with props in `[]` and full blocks of components will get rendered from the `components/yui` views folder to aid your fast development. See the examples below. Note that the default props are `slot` (the children entities), `class` (the default parent classes which you can overwrite) and `extras` (which is any attributes you want placed to the parent component).

```php
<?php
echo yui("alert", ['type' => "warning", 'slot' =>
<<<YUI
<h2>Warning: Your data bundle is down to 7MB. Wanna buy more?</h2>
YUI]);

echo yui("rich-editor", ['action' => '/posts', 'actionLabel' => 'Submit', 'slot' =>
<<<YUI
<h2>Rich Text Editor Works!</h2>
YUI]);
```

### Last Updated: December 12, 2025

