import { PostModel } from "./PostModel";
import { BaseComponent } from "../../../viewi/core/component/baseComponent";
import { register } from "../../../viewi/core/di/register";
import { json_encode } from "../functions/json_encode";
import { Layout } from "./Layout";

var HttpClient = register.HttpClient;

class HomePage extends BaseComponent {
    _name = 'HomePage';
    title = "Viewi - Reactive application for PHP";
    post = null;
    http = null;

    constructor(http) {
        super();
        var $this = this;
        $this.http = http;
    }

    init() {
        var $this = this;
        $this.http.get("\/api\/posts\/5").then(function (data) {
            $this.post = data;
        }, function (error) {
            console.log(error);
        });
    }
}

export const HomePage_x = [
    function (_component) { return _component.title; },
    function (_component) { return _component.title; },
    function (_component) { return " " + (json_encode(_component.post) ?? ""); }
];

export { HomePage }