<?php

namespace Components\Views\StatefulTodoApp;

use Components\Services\Reducers\TodoReducer;
use Viewi\Components\BaseComponent;
use Viewi\Components\DOM\DomEvent;

class StatefulTodoApp extends BaseComponent
{
    public string $text = '';
    public function __construct(public TodoReducer $todo)
    {
    }

    public function handleSubmit(DomEvent $event)
    {
        $event->preventDefault();
        if (strlen($this->text) == 0) {
            return;
        }
        $this->todo->addNewItem($this->text);
        $this->text = '';
    }
}
