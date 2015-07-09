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
      stylus: {
        files: ['./src/stylus/*.styl'],
        tasks: ['stylus:compile']
      },
      gruntfile: {
        files: ['Gruntfile.js']
      },
      typescript: {
        files: './src/typescript/*.ts',
        tasks: ['typescript']
      },
      sass: {
        files: ['./src/sass/*.scss'],
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
    typescript: {
      base: {
        src: ['scripts/typescript/*.ts'],
        dest: ['javascripts'],
        options: {
          module: 'commonjs',
          target: 'ES5'
        }
      }
    }

  });

  // Load the required plugins
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-typescript');

  // Register task(s).
  grunt.registerTask('dev', [ 'compass:dev', 'typescript', 'watch']);
  grunt.registerTask('prod', ['compass:prod']);

};
