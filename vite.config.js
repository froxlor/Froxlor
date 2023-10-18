import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { viteRequire } from 'vite-require'

export default defineConfig({
	build: {
		chunkSizeWarningLimit: 1000,
	},
	plugins: [
		laravel({
			input: [
				'templates/Froxlor/assets/scss/app.scss',
				'templates/Froxlor/assets/js/app.js',
			],
			hotFile: 'templates/Froxlor/hot',
			buildDirectory: '../templates/Froxlor/build',
			refresh: true,
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
	resolve: {
		alias: {
			vue: 'vue/dist/vue.esm-bundler.js',
		},
	},
});
