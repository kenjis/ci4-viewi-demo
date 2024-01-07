import { BaseComponent } from "../../../viewi/core/component/baseComponent";

class Counter extends BaseComponent {
    _name = 'Counter';
    count = 0;

    increment() {
        var $this = this;
        $this.count++;
    }

    decrement() {
        var $this = this;
        $this.count--;
    }
}

export const Counter_x = [
    function (_component) { return function (event) { _component.decrement(event); }; },
    function (_component) { return _component.count; },
    function (_component) { return function (event) { _component.increment(event); }; }
];

export { Counter }