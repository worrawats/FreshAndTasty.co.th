module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				files: {
					'../css/eltdf-options.css': '../css/scss/eltdf-options.scss',
					'../css/eltdf-forms.css': '../css/scss/eltdf-forms.scss',
					'../css/eltdf-meta-boxes.css': '../css/scss/eltdf-meta-boxes.scss',
					'../css/eltdf-meta-boxes.css': '../css/scss/eltdf-meta-boxes.scss',
					'../css/eltdf-ui/eltdf-ui.css': '../css/scss/eltdf-ui/eltdf-ui.scss'
				}
			}
		},
		watch: {
			css: {
				files: [ '../css/scss/*.scss', '../css/scss/*/*.scss',  '../css/scss/*/*/*/.scss'],
				tasks: ['sass'],
				options: {
					spawn: false
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
};