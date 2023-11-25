const defaultConfig = require("@wordpress/scripts/config/webpack.config");

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		style: "./src/css/app.css",
		editor: "./src/css/editor.css",
		script: "./src/js/main.js",
	},
};
