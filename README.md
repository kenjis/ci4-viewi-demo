# CodeIgniter4 Viewi Demo

## How to Run

```console
$ git clone https://github.com/kenjis/ci4-viewi-demo.git
$ cd ci4-viewi-demo/
$ composer install
```

```console
$ php spark serve
```

Navigate to <http://localhost:8080/>.

## Folder Structure

```
.
├── app/
│   ├── Adapters/ ... Adapters for Viewi
│   └── ViewiApp/ ... Viewi App
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

use Viewi\BaseComponent;

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
<button (click)="decrement()" class="mui-btn mui-btn--accent">-</button>
<span class="mui--text-dark mui--text-title">$count</span>
<button (click)="increment()" class="mui-btn mui-btn--accent">+</button>
```

## References

- https://www.codeigniter.com/
- https://viewi.net/
