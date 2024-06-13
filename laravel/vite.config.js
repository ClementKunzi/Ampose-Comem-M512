import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    esbuild: {
        jsxInject: `import React from 'react'`,
        target: [
            "chromeLatest",
            "edgeLatest",
            "es2020",
            "firefoxLatest",
            "safariLatest",
        ], // Mettre à jour vers les dernières versions
    },
    plugins: [
        laravel({
            input: ["resources/js/app.js", "resources/css/app.css"],
            // Vous pouvez ajouter d'autres options de configuration ici si nécessaire
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    base: process.env.APP_ENV === "production" ? "/build/" : "/",
});
