import FroalaEditor from 'froala-editor';
import axios from 'axios';

class PluginsLoader {
    constructor(options, notificator) {
        this.options = options;
        this.notificator = notificator;
    }
    async registerCustomButtons() {
        if (this.options.customToolbarButtons) {
            let asyncRequests = Object.values(this.options.customToolbarButtons).map((path) => {
                return new Promise(async(resolve) => {
                    try {
                        let data = await axios.get(window.location.origin + path);
                        resolve(eval(`const c = ${data.data};c;`)(FroalaEditor));
                    } catch (e) {
                        this.errorCustomButtonLoadNotification(path, e);
                    }
                })
            });

            return await Promise.all(asyncRequests)
        }
    }

    async registerPlugins() {
        let allButtons = this.getRequestedButtons();

        if (_.isEmpty(allButtons)) {
            return true;
        }

        if (allButtons.includes('embedly')) {
            try {
                await import(
                    /* webpackChunkName: "embedly.min" */
                    'froala-editor/js/third_party/embedly.min'
                );
            } catch (e) {
                this.errorPluginLoadNotification('Embed.ly')
            }
        }

        if (allButtons.includes('spellChecker')) {
            try {
                await import(
                    /* webpackChunkName: "spell_checker.min" */
                    'froala-editor/js/third_party/spell_checker.min'
                );
            } catch (e) {
                this.errorPluginLoadNotification('SCAYT Web SpellChecker')
            }
        }

        if (this.options.tuiEnable) {
            try {
                await import(
                    /* webpackChunkName: "image_tui.min" */
                    'froala-editor/js/third_party/image_tui.min.js'
                );
            } catch (e) {
                this.errorPluginLoadNotification('TUI Advanced Image Editor')
            }
        }

        return true;
    }

    getRequestedButtons() {
        const props = [
            'toolbarButtons',
            'toolbarButtonsMD',
            'toolbarButtonsSM',
            'toolbarButtonsXS'
        ];

        let buttons = [];

        for (let prop of props) {
            buttons.push(typeof this.options[prop] === 'undefined' ? null : this.options[prop]);
        }

        return buttons.flat(2);
    }

    errorPluginLoadNotification(name) {
        this.notificator.show(
            `Something wrong with ${name} plugin load. `
            + 'Perhaps you forgot to publish it.',
            { type: 'error' }
        );
    }

    errorCustomButtonLoadNotification(path, e) {
        this.notificator.show(
            `Something wrong when loading ${path}.`
            + `Message: ${e.message}`,
            { type: 'error' }
        );
    }
}

export default PluginsLoader;
