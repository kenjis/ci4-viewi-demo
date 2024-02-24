import { BaseComponent } from "../../../viewi/core/component/baseComponent";
import { ConfigService } from "./ConfigService";
import { register } from "../../../viewi/core/di/register";
import { implode } from "../functions/implode";

var HttpClient = register.HttpClient;

class CssBundle extends BaseComponent {
    _name = 'CssBundle';
    config = null;
    http = null;
    constructor(config, http) {
        super();
        var $this = this;
        config = typeof config !== 'undefined' ? config : null;
        http = typeof http !== 'undefined' ? http : null;
        $this.config = config;
        $this.http = http;
    }
    links = [];
    minify = false;
    combine = false;
    inline = false;
    purge = false;
    cssHtml = "<!--- CssBundle not initiated --->";

    mounted() {
        var $this = this;
        var baseUrl = $this.config.get("assetsUrl");
        if ($this.combine) {
            var cssBundleList = $this.config.get("cssBundle");
            var version = $this.version();
            if (!(version in cssBundleList)) {
                throw new Exception("Css bundle not found");
            }
            var cssFile = baseUrl + cssBundleList[version];
            if ($this.inline) {
                $this.cssHtml = "<style data-keep=\"" + version + "\"> \/** loading " + cssFile + " **\/ <\/style>";
                $this.http.get(cssFile).then(function (css) {
                    $this.cssHtml = "<style data-keep=\"" + version + "\">" + css + "<\/style>";
                }, function () {
                    $this.cssHtml = "<style data-keep=\"" + version + "\"> \/** Error loading " + cssFile + " **\/ <\/style>";
                });
                return;
            }
            $this.cssHtml = "<link rel=\"stylesheet\" href=\"" + cssFile + "\">";
        }
        else {
            var cssHtml = "";
            for (var _i0 in $this.links) {
                var link = $this.links[_i0];
                cssFile = baseUrl + link;
                cssHtml += "<link rel=\"stylesheet\" href=\"" + cssFile + "\">";
                $this.cssHtml = cssHtml;
            }
        }
    }

    version() {
        var $this = this;
        var key = implode("|", $this.links);
        key += $this.minify ? "1" : "0";
        key += $this.inline ? "1" : "0";
        key += $this.purge ? "1" : "0";
        key += $this.combine ? "1" : "0";
        return key;
    }
}

export const CssBundle_x = [
    function (_component) { return _component.cssHtml; }
];

export { CssBundle }