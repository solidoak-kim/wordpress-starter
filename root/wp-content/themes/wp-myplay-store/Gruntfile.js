'use strict';

module.exports = function(grunt){

  // Project configuration
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      options: {
        livereload: true
      },
      php: {
        files: ['./*.php']
      },
      gruntfile: {
        files: ['Gruntfile.js']
      },
      sass: {
        files: ['src/sass/*.scss'],
        tasks: ['compass:dev']
      }
    },

    // Compoass Sass compile task
    compass: {
      prod: {
        options: {
          sassDir: ['src/sass'],
          cssDir: ['stylesheets'],
          environment: 'production'
        }
      },
      dev: {
        options: {
          sassDir: ['src/sass'],
          cssDir: ['stylesheets'],
          environment: 'development'
        }
      }
    },

    // Typescript compile task
    ts: {
      dev: {
        src: ['src/typescript/*.ts'],
        out: 'javascripts/main.js',
        watch: 'src/typescript',
        options: {
          module: 'commonjs'
        }
      }
    }

  });

  // Load the required plugins
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-ts');

  // Register task(s).
  grunt.registerTask('dev', ['watch', 'compass:dev', 'ts:dev']);
  grunt.registerTask('prod', ['compass:prod']);

};
