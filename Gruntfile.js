e strict';

module.exports = function(grunt){

  // Project configuration
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      options: {
        livereload: true
      },
      php: {
        files: ['**/*.php']
      },
      css: {
        files: ['**/*.css']
      },
      stylus: {
        files: ['styles/stylus/*.styl'],
        tasks: ['stylus:compile']
      },
      gruntfile: {
        files: ['Gruntfile.js']
      },
      typescript: {
        files: 'scripts/typescript/*.ts',
        tasks: ['typescript']
      }
    },

    // Stylus compile task
    stylus: {
      compile: {
        options: {
          paths: ['styles/stylus']
        },
        files: {
          'styles/css/application.css': 'styles/stylus/application.styl'
        }
      }
    },

    // Typescript compile task
    typescript: {
      base: {
        src: ['scripts/typescript/*.ts'],
        dest: 'scripts/js',
        options: {
          module: 'commonjs',
          target: 'ES3',
          sourceMap: true,
          removeComments: true,
        }
      }
    }

  });

  // Load the required plugins
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-stylus');
  grunt.loadNpmTasks('grunt-typescript');

  // Default task(s).
  grunt.registerTask('default', ['watch', 'stylus']);

};
