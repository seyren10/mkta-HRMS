import "./bootstrap";

import { createApp, markRaw, ref, toRef } from "vue";
import router from "@/router/index.js";
import { createPinia } from "pinia";

import App from "./App.vue";

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import "@mdi/font/css/materialdesignicons.css";

const vuetify = createVuetify({
    theme: {
        defaultTheme: "myCustomTheme",
        themes: {
            myCustomTheme: {
                dark: false,
                colors: {
                    primary: "#42A5F5",
                    secondary: "#546E7A",
                    accent: "#82B1FF",
                    "accent-light": "#E3F2FD",
                    background: "#EEEEEE",
                },
            },
        },
    },
});

const pinia = createPinia();
// adding global loading and error state to every store
pinia.use(({ store }) => {
    if (!Object.prototype.hasOwnProperty(store.$state, "loading")) {
        const loading = ref(false);
        store.$state.loading = loading;
    }
    store.loading = toRef(store.$state, "loading");
});
pinia.use(({ store }) => {
    if (!Object.prototype.hasOwnProperty(store.$state, "errors")) {
        const errors = ref({});
        store.$state.errors = errors;
    }
    store.errors = toRef(store.$state, "errors");
});

pinia.use(({ store }) => (store.router = markRaw(router))); //giving pinia access to vue-router instance

const app = createApp(App);
app.use(pinia);
app.use(router);
app.use(vuetify);
app.mount("#app");
