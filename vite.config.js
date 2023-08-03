import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify from "vite-plugin-vuetify";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        vue({
            template:
                {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                    compilerOptions: {
                        // i am ignorning my custom '<container>' tag
                        isCustomElement: (tag) => ["container"].includes(tag),
                    },
                },
        }),
        vuetify({ autoImport: true }),
    ],
});
