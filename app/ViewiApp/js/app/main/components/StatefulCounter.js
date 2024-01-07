import { CounterReducer } from "./CounterReducer";
import { BaseComponent } from "../../../viewi/core/component/baseComponent";

class StatefulCounter extends BaseComponent {
    _name = 'StatefulCounter';
    counter = null;
    constructor(counter) {
        super();
        var $this = this;
        $this.counter = counter;
    }
}

export const StatefulCounter_x = [
    function (_component) { return function (event) { _component.counter.decrement(event); }; },
    function (_component) { return _component.counter.count; },
    function (_component) { return function (event) { _component.counter.increment(event); }; }
];

export { StatefulCounter }