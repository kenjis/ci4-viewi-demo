import { register } from "../../../viewi/core/di/register";

var Platform = register.Platform;

class ConfigService {
    config = null;
    platform = null;

    constructor(platform) {
        var $this = this;
        $this.platform = platform;
        $this.config = platform.getConfig();
    }

    getAll() {
        var $this = this;
        return $this.config;
    }

    get(name) {
        var $this = this;
        return $this.config[name] ?? null;
    }

    isServer() {
        var $this = this;
        return $this.platform.server;
    }

    isBrowser() {
        var $this = this;
        return $this.platform.browser;
    }
}

export { ConfigService }