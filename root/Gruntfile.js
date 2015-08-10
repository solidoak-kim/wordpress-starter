'use strict';

module.exports = function (grunt) {

  // This banner will get inserted at the top of the generated files (minified CSS/JS)
  var banner = '' +
    '/*!\n' +
    ' * <%= pkg.name %>\n' +
    ' * Version: <%= pkg.version %>\n' +
    ' * Build date: <%= grunt.template.today("yyyy-mm-dd HH:MM:ss") %>\n' +
    ' */\n\n';

  // Project configuration
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    watch: {
      options: {
        livereload: true
      },
      php: {
        files: ['./wp-content/**/*.php']
      },
      twig: {
        files: ['./wp-content/**/*.twig']
      },
      gruntfile: {
        files: ['Gruntfile.js']
      },
      sass: {
        files: ['./wp-content/themes/<%= pkg.name %>/styles/scss/*.scss'],
        tasks: ['compass:dev']
      },
      scripts: {
        files: ['./wp-content/themes/<%= pkg.name %>/scripts/js/*.js'],
        tasks: ['jshint']
      }
    },

    // Compass Sass tasks
    compass: {
      prod: {
        options: {
          sassDir: ['./wp-content/themes/<%= pkg.name %>/styles/scss'],
          cssDir: ['./wp-content/themes/<%= pkg.name %>/styles/css'],
          environment: 'production'
        }
      },
      dev: {
        options: {
          noLineComments: true,
          sassDir: ['./wp-content/themes/<%= pkg.name %>/styles/scss'],
          cssDir: ['./wp-content/themes/<%= pkg.name %>/styles/css'],
          sourcemap: true,
          environment: 'development'
        }
      }
    },

    // Typescript tasks
    typescript: {
      base: {
        src: ['./wp-content/themes/<%= pkg.name %>/scripts/typescript/*.ts'],
        dest: './wp-content/themes/<%= pkg.name %>/scripts/js/',
        options: {
          module: 'commonjs',
          target: 'es5',
          watch: true,
          sourceMap: true,
          declaration: true
        }
      }
    },

    // Javascript tasks
    jshint: {
      files: ['./wp-content/themes/<%= pkg.name %>/scripts/js/*.js'],
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true
        }
      },
      use_defaults: ['./wp-content/themes/<%= pkg.name %>/scripts/js/*.js']
    }

  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-typescript');

  // Register tasks
  grunt.registerTask('dev', ['compass:dev', 'jshint']);

  // TODO: grunt task to minify css, uglify js, concat files


}