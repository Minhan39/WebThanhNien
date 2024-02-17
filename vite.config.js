import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/styles.css",
                "resources/css/flipbook.style.css",
                "resources/css/font-awesome.css",
                "resources/css/header.css",
                "resources/js/app.js",
                "resources/js/flipbook.book3.min.js",
                "resources/js/flipbook.min.js",
                "resources/js/flipbook.pdfservice.min.js",
                "resources/js/flipbook.swipe.min.js",
                "resources/js/flipbook.webgl.js",
                "resources/js/flipbook.webgl.min.js",
                "resources/js/iscroll.min.js",
                "resources/js/pdf.min.js",
                "resources/js/pdf.worker.min.js",
                "resources/js/three.min.js",
            ],
            refresh: true,
        }),
    ],
});
