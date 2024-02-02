import "./bootstrap";
import "../css/app.css";
import "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js";
import "https://kit.fontawesome.com/42d5adcbca.js";
import "https://buttons.github.io/buttons.js";
import "https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993";
import "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js";
import "../src/js/core/popper.min.js";
import "../src/js/core/bootstrap.min.js";
import "../src/js/plugins/perfect-scrollbar.min.js";
import "../src/js/argon-dashboard.min.js";
// import "../src/js/plugins/smooth-scrollbar.min.js";

import "../src/js/plugins/dragula/dragula.min.js";
// import "../src/js/plugins/jkanban/jkanban.js";
import "../src/js/plugins/chartjs.min.js";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
            .component("font-awesome-icon", FontAwesomeIcon);
    },
    progress: {
        color: "#4B5563",
    },
});
