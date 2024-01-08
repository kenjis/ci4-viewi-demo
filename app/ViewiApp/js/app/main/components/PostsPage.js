import { PostModel } from "./PostModel";
import { BaseComponent } from "../../../viewi/core/component/baseComponent";
import { register } from "../../../viewi/core/di/register";
import { json_encode } from "../functions/json_encode";
import { Layout } from "./Layout";

var HttpClient = register.HttpClient;

class PostsPage extends BaseComponent {
    _name = 'PostsPage';
    title = "Viewi - Reactive application for PHP";
    post = null;
    http = null;
    postId = null;

    constructor(http, postId) {
        super();
        var $this = this;
        $this.http = http;
        $this.postId = postId;
    }

    init() {
        var $this = this;
        $this.http.get("\/api\/posts\/" + $this.postId).then(function (data) {
            $this.post = data;
        }, function (error) {
            console.log(error);
        });
    }
}

export const PostsPage_x = [
    function (_component) { return _component.title; },
    function (_component) { return _component.title; },
    function (_component) { return " " + (json_encode(_component.post) ?? ""); }
];

export { PostsPage }