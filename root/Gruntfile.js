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

    wpThemeDir: './wp-content/themes/<%= pkg.name %>',

    wpThemeStylesDir: '<%= wpThemeDir %>/styles',

    wpThemeScriptsDir: '<%= wpThemeDir %>/scripts',

    wpThemeLibDir: '<%= wpThemeDir %>/lib',

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
        files: [ '<%= wpThemeStylesDir %>/scss/*.scss'],
        tasks: ['compass:dev']
      },
      scripts: {
        files: ['<%= wpThemeScriptsDir %>/js/*.js'],
        tasks: ['jshint']
      }
    },

    // Compass Sass tasks
    compass: {
      prod: {
        options: {
          sassDir: ['<%= wpThemeStylesDir %>/scss'],
          cssDir: ['<%= wpThemeStylesDir %>/css'],
          environment: 'production'
        }
      },
      dev: {
        options: {
          noLineComments: true,
          sassDir: ['<%= wpThemeStylesDir %>/scss'],
          cssDir: ['<%= wpThemeStylesDir %>/css'],
          sourcemap: true,
          environment: 'development'
        }
      }
    },

    // SCSS lint task
    scsslint: {
      allFiles: ['<%= wpThemeStylesDir %>/scss/*.scss'],
      options: {
        bundleExec: false,
        colorizeOutput: true,
        config: '.scss-lint.yml'
      }
    },

    // minify CSS
    cssmin: {
      options: {
        banner: banner
      },
      target: {
        files: [{
          expand: true,
          cwd: '<%= wpThemeStylesDir %>/css',
          src: ['<%= wpThemeStylesDir %>/css/*.css', '!*.min.css'],
          dest: ['<%= wpThemeStylesDir %>/css'],
          ext: '.min.css'
        }]
      }
    },

    // Typescript tasks
    typescript: {
      base: {
        src: ['<%= wpThemeScriptsDir %>/typescript/*.ts'],
        dest: '<%= wpThemeScriptsDir %>/js/',
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
      files: ['<%= wpThemeScriptsDir %>/js/*.js'],
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true
        }
      },
      use_defaults: ['<%= wpThemeScriptsDir %>/js/*.js']
    },

    // Uglify javascript files
    uglify: {
      options: {
        banner: banner,
        compress: {
          drop_console: true
        }
      },
      my_target: {
        files: [{
          expand: true,
          cwd: '<%= wpThemeScriptsDir %>/js',
          src: '<%= wpThemeScriptsDir %>/js/*.js',
          dest: '<%= wpThemeScriptsDir %>/js'
        }]
      }
    },

    // Concat Bower components
    bower_concat: {
      all: {
        dest: '<%= wpThemeLibDir %>/libs.js',
        cssDest: '<%= wpThemeLibDir %>/libs.css',
        exclude: ['jquery'],
        dependencies: {
        },
        bowerOptions: {
          relative: false
        }
      }
    }

  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-typescript');
  grunt.loadNpmTasks('grunt-scss-lint');
  grunt.loadNpmTasks('grunt-bower-concat');

  // Register tasks
  grunt.registerTask('dev', ['compass:dev', 'jshint', 'scsslint', 'bower_concat', 'watch']);
  grunt.registerTask('prod', ['compass:prod', 'jshint', 'scsslint', 'cssmin, uglify']);

}