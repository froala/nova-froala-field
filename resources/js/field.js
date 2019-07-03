require('froala-editor/js/froala_editor.pkgd.min');
require('froala-editor/js/plugins.pkgd.min.js');

import VueFroala from 'vue-froala-wysiwyg';

Nova.booting(Vue => {
    Vue.use(VueFroala);

    Vue.component('index-nova-froala-field', require('./components/IndexField'));
    Vue.component('detail-nova-froala-field', require('./components/DetailField'));
    Vue.component('form-nova-froala-field', require('./components/FormField'));
});
