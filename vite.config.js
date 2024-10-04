import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import AutoImport from 'unplugin-auto-import/vite'

export default defineConfig({
    css: {
        preprocessorOptions: {
          scss: {
            additionalData: `@import './resources/js/src/assets/scss/variables.scss';`
          }
        }
      },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        AutoImport({
            eslintrc: {
              enabled: true,
              filepath: './.eslintrc-auto-import.json',
            },
            imports: ['vue', 'vue-router'],
            vueTemplate: true,
        }),
    ],
    resolve: {
        alias: {
            '@/': __dirname + '/resources/js/src/',
            'vue': 'vue/dist/vue.esm-bundler.js'
        },
    },
});
