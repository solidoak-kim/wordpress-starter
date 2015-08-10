'use strict';

// Basic template description
exports.description = 'Scaffolds a new M2 WordPress starter theme with GruntJS, Compass and Typescript';

// Any existing file or directory matching this wildcard will cause a warning.
exports.warnOn = '*';

// The actual init template.
exports.template = function(grunt, init, done){

  init.process({}, [
    // Prompt for these values
    init.prompt('name'),
    init.prompt('title'),
    init.prompt('description'),
    init.prompt('version')

  ], function(err, props){
    // Files to copy (and process).
    var files = init.filesToCopy(props),
        newThemeFolder = props.name;

    // Update file paths to reflect the name specified from prompt
    for (var file in files) {
      if (file.indexOf('wp-myplay-store/') > -1) {
        var path = files[file],
            newFile = file.replace('wp-myplay-store/', newThemeFolder + '/');
        files[newFile] = path;

        delete files[file];
      }
    }

    // Actually copy (and process) files.
    init.copyAndProcess(files, props);

    // Empty folders won't be copied over create them
    grunt.file.mkdir('wp');

    // Generate package.json file for npm and grunt
    init.writePackageJSON('package.json', {
      name: props.name,
      description: props.description,
      version: props.version,
      devDependencies: {
        "grunt": "^0.4.5",
        "grunt-contrib-watch": "~0.6.x",
        "grunt-contrib-compass": "~0.4.x",
        "grunt-contrib-concat": "^0.5.1",
        "grunt-contrib-jshint": "^0.11.2",
        "grunt-contrib-uglify": "^0.9.1",
        "grunt-contrib-cssmin": "^0.13.0",
        "grunt-typescript" : "~0.7.x",
        "grunt-bower-concat": "~0.5.x",
        "grunt-scss-lint": "^0.3.8"
      }
    });

    // All done!
    done();

  });
};