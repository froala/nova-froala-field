class PluginsLoader {
    constructor(options, notificator) {
        this.options = options;
        this.notificator = notificator;
    }

    async registerPlugins() {
        let allButtons = _.merge(...this.getRequestedButtons());

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

        if (this.options.hasOwnProperty('aviaryKey')) {
            try {
                await import(
                    /* webpackChunkName: "image_aviary.min" */
                    'froala-editor/js/third_party/image_aviary.min'
                );
            } catch (e) {
                this.errorPluginLoadNotification('Aviary')
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

        return buttons;
    }

    errorPluginLoadNotification(name) {
        this.notificator.show(
            `Something wrong with ${name} plugin load. `
            + 'Perhaps you forgot to publish it.',
            { type: 'error' }
        );
    }
}

export default PluginsLoader;