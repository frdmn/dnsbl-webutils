module.exports = function(grunt) {

    var name = 'webdns-utils'
    , version = grunt.file.read('VERSION').trim();

    require('load-grunt-tasks')(grunt);
    require('phplint').gruntPlugin(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json')

        // Helper variables
        , dirs: {
            bower: 'vendor/bower_components'
            , css: 'public/assets/css'
            , js: 'public/assets/js'
            , images: 'public/assets/img'
            , fonts: 'public/assets/fonts'
            , svg: 'public/assets/svg'
            , dist: 'dist'
        }

        /*
         * SASS
         * - Compiles all *.scss files into one style.css
         * - In dev mode there is no minifying
         */

        , sass: {
            dev: {
                options: {
                    outputStyle: 'nested'
                    , sourceMap: true
                }
                , files: {
                    '<%= dirs.css %>/style.css': '<%= dirs.css %>/style.scss'
                }
            }
            , build: {
                options: {
                    outputStyle: 'compressed'
                    , sourceMap: false
                }
                , files: {
                    '<%= dirs.css %>/style.css': '<%= dirs.css %>/style.scss'
                }
            }
        }

        /*
         * Autoprefixer
         * - Makes sure you use the proper vendor-prefixed CSS properties
         */

        , autoprefixer: {
            options: {
                browsers: [ 'last 2 versions' ]
                , map: true
            }
            , dist: {
                files: {
                    '<%= dirs.css %>/style.css': '<%= dirs.css %>/style.css'
                }
            }
        }

        /*
         * Connect
         * - Inbuilt web server
         */

        , connect: {
            server: {
                options: {
                    port: 9001
                    , base: ''
                }
            }
        }

        /*
         * Concat task
         * - Merges all the devided JavaScript into one big one for production use
         * - Ignores "modernizr.js", since it has to be seperate
         */

        , concat: {
            options: {
                separator: ';'
            }
            , dist: {
                src: [
                    '<%= dirs.bower %>/jquery/dist/jquery.js'
                    , '<%= dirs.bower %>/bootstrap-sass-official/assets/javascripts/bootstrap.js'
                    , '<%= dirs.bower %>/jquery.tablesorter/dist/js/jquery.tablesorter.js'
                    , '<%= dirs.bower %>/form.validation/dist/js/formValidation.js'
                    , '<%= dirs.bower %>/form.validation/dist/js/framework/bootstrap.js'
                    , '<%= dirs.bower %>/prism/prism.js'
                    , '<%= dirs.js %>/_SpinSubmit.js'
                    , '<%= dirs.js %>/_check.js'
                    , '!<%= dirs.js %>/modernizr.js'
                    , '!<%= dirs.js %>/build.js'
                ]
                , dest: '<%= dirs.js %>/build.js'
            }
        }

        /*
         * JShint
         * - Validate JavaScript
         */

        , jshint: {
            options: {
                jshintrc: true
            }
            , all: [
                'Gruntfile.js'
                , '<%= dirs.js %>/*.js'
                , '!<%= dirs.js %>/modernizr.js'
                , '!<%= dirs.js %>/build.js'
            ]
        }

        /*
         * HTMLhint
         * - Validate HTML
         */

        , htmlhint: {
            html: {
                options: {
                    'tag-pair': true
                }
                , src: [ '*.html' ]
            }
        }

        /*
         * Uglify
         * - Minify JavaScript
         */

        , uglify: {
            core: {
                files: [
                  {
                      '<%= dirs.js %>/build.js': [ '<%= dirs.js %>/build.js' ]
                      , '<%= dirs.js %>/modernizr.js': [ '<%= dirs.bower %>/modernizr/modernizr.js' ]
                  }
                ]
            }
        }

        /*
         * Imagemin
         * - Minify images
         */

        , imagemin: {
            dynamic: {
                files: [ {
                    expand: true
                    , cwd: '<%= dirs.images %>'
                    , src: [ '**/*.{png,jpg,gif}' ]
                    , dest: '<%= dirs.images %>'
                } ]
            }
        }

        /*
         * Copy
         * - Copy files via Grunt from A to B
         * - Used for Bootstraps fonts which are included in the bower component folder
         */

        , copy: {
          main: {
            files: [
              { expand: true, cwd: '<%= dirs.bower %>/bootstrap-sass-official/assets/fonts/bootstrap/', src: [ '**' ], dest: '<%= dirs.fonts %>' }
              ,{ expand: true, cwd: '<%= dirs.bower %>/prism/themes/', src: [ 'prism.css' ], dest: '<%= dirs.css %>', rename: function(dest) { return dest + '/_prism.scss'; } }
            ]
          }
          , release: {
            files: [
              { expand: true, cwd: './', src: [ '**', '!node_modules/**', '!vendor/**', '!config/config.php', '!<%= dirs.css %>/*.scss', '!<%= dirs.js %>/_*.js', '!<%= dirs.dist %>' ], dest: '<%= dirs.dist %>' }
            ]
          }
        }

        /*
         * JSCS (JavaScriptCodeStyle)
         * - Check JS markup based on policies defined in .jscsrc
         */

        , jscs: {
          src: '<%= dirs.js %>/_*.js'
          , options: {
            config: '.jscsrc'
          }
        }

        /*
         * phplint
         * - Check for PHP syntax errors
         */

        , phplint: {
          options: {
            stdout: true
            , stderr: true
          }
          , files: [ '*.php' ]
        }

        /*
         * clean
         * empty dist/ folder before release
         */

        , clean: [ '<%= dirs.dist %>' ]

        /*
         * compress
         * create archive for GitHub release
         */

        , compress: {
            main: {
              options: {
                archive: function () {
                  // The global value git.tag is set by another task
                  return name + '-v' + version + '.zip'
                }
              }
              , files: [
                { src: [ '<%= dirs.dist %>/*' ] } // includes files in path
              ]
            }
          }


        /*
         * Watch
         * - Watches files for changes and recompiles if neccesary
         */

        , watch: {
            options: {
                livereload: true
            }
            , sass: {
                files: [ '<%= dirs.css %>/*.scss' ]
                , tasks: [ 'sass:dev', 'autoprefixer' ]
            }
            , images: {
                files: [ '<%= dirs.images %>/*.{png,jpg,gif}' ]
                , tasks: [ 'imagemin' ]
            }
            , html: {
                files: [ '*.html' ]
                , tasks: [ 'htmlhint' ]
            }
            , php: {
                files: [ '*.php', 'actions/*.php', 'ajaxactions/*.php' ]
                , tasks: [ 'phplint' ]
            }
            , scripts: {
                files: [ 'Gruntfile.js', '<%= dirs.js %>/*.js' ]
                , tasks: [ 'jshint', 'jscs', 'concat' ]
                , options: {
                    spawn: false
                }
            }
        }
    });

    grunt.registerTask('default', [ 'copy:main', 'sass:build', 'autoprefixer', 'concat', 'uglify', 'imagemin', 'jscs', 'phplint' ]);
    grunt.registerTask('dev', [ 'copy:main', 'connect', 'watch' ]);
    grunt.registerTask('release', [ 'copy:release', 'compress', 'clean' ]);
};
