# CodeIgniter4 Viewi Demo

> Viewi allows you to create reactive web applications using your favorite PHP.
> It converts your code into native javascript code to run it in the browser.
> This way, you get a perfectly rendered HTML page on the first load, and at the
> same time, your page will remain reactive without requesting each next page on
> link clicks, etc.
https://viewi.net/

## Installation

```console
$ git clone https://github.com/kenjis/ci4-viewi-demo.git
$ cd ci4-viewi-demo/
$ composer install
```

## Running Application

Assuming you have done composer install/update.

In the first terminal:
```console
$ cd app/ViewiApp/js/
```

Install NPM packages, if you are running for the first time:
```console
$ npm install
```

Run watch mode:
```console
$ npm run watch
```

In the second terminal:
```console
php spark serve
```

Navigate to <http://localhost:8080/>.

## Folder Structure

```
.
├── app/
│   ├── ViewiBridge/ ... Adapters for Viewi
│   └── ViewiApp/    ... Viewi App
│        ├── Components/
│        │   ├── Models/
│        │   ├── Services/
│        │   └── Views/
│        ├── build/     ... Do not touch
│        ├── config.php ... Viewi config file
│        └── routes.php ... Viewi routes file
├── public/
│   └── viewi-build/ ... Do not touch
```

## How to Code

`app/ViewiApp/Components/Views/Counter/Counter.php`:
```php
<?php

namespace Components\Views\Counter;

use Viewi\Components\BaseComponent;

class Counter extends BaseComponent
{
    public int $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }
}
```

`app/ViewiApp/Components/Views/Counter/Counter.html`:
```html
<button (click)="decrement" class="mui-btn mui-btn--accent">-</button>
<span class="mui--text-dark mui--text-title">$count</span>
<button (click)="increment" class="mui-btn mui-btn--accent">+</button>
```

## How to Confirm Routes

```console
$ php spark routes

CodeIgniter v4.4.4 Command Line Tool - Server Time: 2024-02-24 08:15:13 UTC+00:00

+--------+--------------------+------+--------------------------------------+----------------+---------------+
| Method | Route              | Name | Handler                              | Before Filters | After Filters |
+--------+--------------------+------+--------------------------------------+----------------+---------------+
| GET    | api/posts/([0-9]+) | »    | \App\Controllers\Api\Posts::index/$1 |                | toolbar       |
+--------+--------------------+------+--------------------------------------+----------------+---------------+
```

See `app/ViewiApp/routes.php` for routes by Viewi.

## How Viewi Works with CodeIgniter

[CodeIgniter4 Viewi integration](https://viewi.net/docs/code-igniter)

## References

- https://www.codeigniter.com/
- https://viewi.net/
- [CodeIgniter4 Viewi integration](https://viewi.net/docs/code-igniter)
- [CodeIgniter4 User Guide](https://codeigniter4.github.io/CodeIgniter4/)
- [CodeIgniter4 Viewi Tour of Heroes app](https://github.com/kenjis/ci4-viewi-tour-of-heroes)
