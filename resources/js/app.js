import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import {Link, Head} from "@inertiajs/inertia-vue3";

window.axios = require('axios');

import VueSweetalert2 from "vue-sweetalert2";
import Swal from 'sweetalert2'

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .mixin({methods: { route: window.route }})
            .use(plugin)
            .use(VueSweetalert2)
            .component('Link',Link)
            .component('Head',Head)
            .component('Swal',Swal)
            .mount(el)
    },
}).then(r =>{})
