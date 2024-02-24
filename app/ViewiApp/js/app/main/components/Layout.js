import { BaseComponent } from "../../../viewi/core/component/baseComponent";
import { CssBundle } from "./CssBundle";
import { MenuBar } from "./MenuBar";
import { ViewiAssets } from "./ViewiAssets";

class Layout extends BaseComponent {
    _name = 'Layout';
    title = "Viewi";
}

export const Layout_x = [
    function (_component) { return "\n        " + (_component.title ?? "") + " | Viewi\n    "; },
    function (_component) { return ["\/mui.css", "\/app.css"]; }
];

export { Layout }