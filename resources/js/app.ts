import './bootstrap';
import '../css/app.css';
import i18n from '@/Core/plugins/i18n';
import "element-plus/dist/index.css";

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import {createPinia} from "pinia";

let appName = import.meta.env.VITE_APP_NAME || 'Muhuri-central-admin';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(createPinia())
            .mount(el);
    },
    progress: {
        color: '#ffd400',
    },
});
