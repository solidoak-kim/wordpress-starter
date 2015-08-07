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

    var files = init.filesToCopy(props);

    // Actually copy (and process) files.
    init.copyAndProcess(files, props);

    // Empty folders won't be copied over so make them here
    grunt.file.mkdir('wp');

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