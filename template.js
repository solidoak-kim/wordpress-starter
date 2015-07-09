'use strict';

// Basic template description
exports.description = 'Scaffolds a new WordPress starter theme with GruntJS, Compass and Typescript';

// Any existing file or directory matching this wildcard will cause a warning.
exports.warnOn = '*';

// The actual init template.
exports.template = function(grunt, init, done){

  init.process({}, [
    // Prompt for these values
    //  init.prompt('name'),
    //  init.prompt('title'),
    //  init.prompt('description'),
    //  init.prompt('version')

  ], function(err, props){
    // Files to copy (and process).

    var files = init.filesToCopy(props);

    // Actually copy (and process) files.
    init.copyAndProcess(files, props);

    // Empty folders won't be copied over so make them here
    grunt.file.mkdir('wp');

    // Generate package.json file, used by npm and grunt.
    //init.writePackageJSON('package.json', {
    //  name: props.name,
    //  description: props.description,
    //  version: props.version,
    //  devDependencies: {
    //    "grunt-contrib-watch": "~v0.6.x",
    //    "grunt-contrib-stylus": "~v0.21.x",
    //    "grunt-typescript": "~v0.6.x"
    //  }
    //});

    // All done!
    done();

  });
};