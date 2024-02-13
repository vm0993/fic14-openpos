import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    build: {
        commonjsOptions: {
            include: ["tailwind.config.js", "node_modules/**"],
        },
    },
    optimizeDeps: {
        include: ["tailwind-config"],
    },
    plugins: [
        laravel({
            input: [
                // CSS Vendors
                "resources/css/vendors/ckeditor.css",
                "resources/css/vendors/dropzone.css",
                "resources/css/vendors/full-calendar.css",
                "resources/css/vendors/highlight.css",
                "resources/css/vendors/leaflet.css",
                "resources/css/vendors/litepicker.css",
                "resources/css/vendors/simplebar.css",
                "resources/css/vendors/tabulator.css",
                "resources/css/vendors/tiny-slider.css",
                "resources/css/vendors/tippy.css",
                "resources/css/vendors/toastify.css",
                "resources/css/vendors/tom-select.css",
                "resources/css/vendors/zoom-vanilla.css",

                // CSS Themes
                "resources/css/themes/enigma/side-nav.css",
                "resources/css/themes/enigma/top-nav.css",
                "resources/css/themes/icewall/side-nav.css",
                "resources/css/themes/icewall/top-nav.css",
                "resources/css/themes/rubick/side-nav.css",
                "resources/css/themes/rubick/top-nav.css",
                "resources/css/themes/tinker/side-nav.css",
                "resources/css/themes/tinker/top-nav.css",

                // CSS Components
                "resources/css/components/mobile-menu.css",

                // CSS General
                "resources/css/app.css",

                // JS Vendor
                "resources/js/vendors/accordion.js",
                "resources/js/vendors/alert.js",
                "resources/js/vendors/axios.js",
                "resources/js/vendors/calendar/calendar.js",
                "resources/js/vendors/calendar/plugins/day-grid.js",
                "resources/js/vendors/calendar/plugins/interaction.js",
                "resources/js/vendors/calendar/plugins/list.js",
                "resources/js/vendors/calendar/plugins/time-grid.js",
                "resources/js/vendors/chartjs.js",
                "resources/js/vendors/dayjs.js",
                "resources/js/vendors/ckeditor/balloon.js",
                "resources/js/vendors/ckeditor/balloon-block.js",
                "resources/js/vendors/ckeditor/classic.js",
                "resources/js/vendors/ckeditor/document.js",
                "resources/js/vendors/ckeditor/inline.js",
                "resources/js/vendors/popper.js",
                "resources/js/vendors/dom.js",
                "resources/js/vendors/dropdown.js",
                "resources/js/vendors/dropzone.js",
                "resources/js/vendors/highlight.js",
                "resources/js/vendors/image-zoom.js",
                "resources/js/vendors/leaflet-map.js",
                "resources/js/vendors/litepicker.js",
                "resources/js/vendors/lodash.js",
                "resources/js/vendors/lucide.js",
                "resources/js/vendors/modal.js",
                "resources/js/vendors/pristine.js",
                "resources/js/vendors/simplebar.js",
                "resources/js/vendors/svg-loader.js",
                "resources/js/vendors/tab.js",
                "resources/js/vendors/tabulator.js",
                "resources/js/vendors/tailwind-merge.js",
                "resources/js/vendors/tiny-slider.js",
                "resources/js/vendors/tippy.js",
                "resources/js/vendors/toastify.js",
                "resources/js/vendors/tom-select.js",
                "resources/js/vendors/transition.js",
                "resources/js/vendors/xlsx.js",

                // JS Utils
                "resources/js/utils/colors.js",
                "resources/js/utils/helper.js",

                // JS Pages
                "resources/js/pages/chat.js",
                "resources/js/pages/modal.js",
                "resources/js/pages/notification.js",
                "resources/js/pages/slideover.js",
                "resources/js/pages/tabulator.js",
                "resources/js/pages/validation.js",

                // JS Themes
                "resources/js/themes/rubick.js",
                "resources/js/themes/icewall.js",
                "resources/js/themes/tinker.js",
                "resources/js/themes/enigma.js",

                // JS Base Components
                "resources/js/components/base/theme-color.js",
                "resources/js/components/base/calendar/calendar.js",
                "resources/js/components/base/calendar/draggable.js",
                "resources/js/components/base/balloon-block-editor.js",
                "resources/js/components/base/balloon-editor.js",
                "resources/js/components/base/classic-editor.js",
                "resources/js/components/base/document-editor.js",
                "resources/js/components/base/dropzone.js",
                "resources/js/components/base/highlight.js",
                "resources/js/components/base/inline-editor.js",
                "resources/js/components/base/leaflet-map-loader.js",
                "resources/js/components/base/litepicker.js",
                "resources/js/components/base/lucide.js",
                "resources/js/components/base/preview-component.js",
                "resources/js/components/base/source.js",
                "resources/js/components/base/tiny-slider.js",
                "resources/js/components/base/tippy.js",
                "resources/js/components/base/tippy-content.js",
                "resources/js/components/base/tom-select.js",

                // JS Components
                "resources/js/components/themes/enigma/top-bar.js",
                "resources/js/components/themes/icewall/top-bar.js",
                "resources/js/components/themes/rubick/top-bar.js",
                "resources/js/components/themes/tinker/top-bar.js",
                "resources/js/components/donut-chart.js",
                "resources/js/components/horizontal-bar-chart.js",
                "resources/js/components/line-chart.js",
                "resources/js/components/mobile-menu.js",
                "resources/js/components/pie-chart.js",
                "resources/js/components/report-bar-chart-1.js",
                "resources/js/components/report-bar-chart.js",
                "resources/js/components/report-donut-chart-1.js",
                "resources/js/components/report-donut-chart-2.js",
                "resources/js/components/report-donut-chart.js",
                "resources/js/components/report-line-chart.js",
                "resources/js/components/report-pie-chart.js",
                "resources/js/components/simple-line-chart-1.js",
                "resources/js/components/simple-line-chart-2.js",
                "resources/js/components/simple-line-chart-3.js",
                "resources/js/components/simple-line-chart-4.js",
                "resources/js/components/simple-line-chart.js",
                "resources/js/components/stacked-bar-chart-1.js",
                "resources/js/components/stacked-bar-chart.js",
                "resources/js/components/vertical-bar-chart.js",

                // JS General
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "tailwind-config": path.resolve(__dirname, "./tailwind.config.js"),
        },
    },
});
