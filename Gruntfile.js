module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    secret: grunt.file.readJSON('secret.json'),
    pkg: grunt.file.readJSON('package.json'),
    sass: {                              // Task
      dist: {                            // Target
        options: {                       // Target options
          style: 'expanded'
        },
        files: {                         // Dictionary of files
          './css/build/unprefixed/admin.css': './css/sass/admin.scss',       // 'destination': 'source'
          './css/build/unprefixed/check.css': './css/sass/check.scss',       // 'destination': 'source'
          './css/build/unprefixed/lager.css': './css/sass/lager.scss',       // 'destination': 'source'
          './css/build/unprefixed/global.css': './css/sass/global.scss',       // 'destination': 'source'
          './css/build/unprefixed/print.css': './css/sass/print.scss',
          './css/build/unprefixed/reset.css': './css/sass/reset.scss',
        },
      },
    },
    svgstore: {
      options: {
        cleanup : true,
        svg: {
          style: "display: none;",
        },
      },
      default : {
        files: {
          './web/includes/icons.svg': ['./icons/svg/*.svg'],
        },
      },
    },
    autoprefixer: {
      options: {
        map: true,
        browsers: ['last 2 version'],
      },
      multiple_files: {
        expand: true,
        flatten: true,
        src: './css/build/unprefixed/*.css',
        dest: './css/build/prefixed/'
      },
    },
    cssmin: {
      my_target: {
        files: [{
          expand: true,
          flatten: true,
          src: ['./css/build/prefixed/*.css'],
          dest: './web/media/css/',
          ext: '.css'
        }]
      },
    },
    sftp: {
      css_upload: {
        files: {
          "./": ["web/media/css/*"],
        },
        options: {
          path: '/var/schlangennest/media/css',
          srcBasePath: 'web/media/css/',
          host: '<%= secret.hal.host %>',
          port: '<%= secret.hal.port %>',
          username: '<%= secret.hal.username %>',
          privateKey: grunt.file.read("id_dsa"),
          showProgress: true
        },
      },
      upload: {
        files: {
          "./": ["web/**"],
        },
        options: {
          path: '/var/www/schlangennest',
          srcBasePath: 'web/',
          host: '<%= secret.bob.host %>',
          port: '<%= secret.bob.port %>',
          username: '<%= secret.bob.username %>',
          privateKey: grunt.file.read("id_dsa"),
          showProgress: true
        }
      },
      upload_dev: {
        files: {
          "./": ["web/**"],
        },
        options: {
          path: '/var/schlangennest',
          srcBasePath: 'web/',
          host: '<%= secret.hal.host %>',
          port: '<%= secret.hal.port %>',
          username: '<%= secret.hal.username %>',
          privateKey: grunt.file.read("id_dsa"),
          showProgress: true
        }
      }
    },
    sshexec: {
      stop_server: {
        command: 'sudo service apache2 stop',
        options: {
          host: '<%= secret.bob.host %>',
          port: '<%= secret.bob.port %>',
          username: '<%= secret.bob.username %>',
          privateKey: grunt.file.read("id_dsa")
        },
      },
      start_server: {
        command: 'sudo service apache2 start',
        options: {
          host: '<%= secret.bob.host %>',
          port: '<%= secret.bob.port %>',
          username: '<%= secret.bob.username %>',
          privateKey: grunt.file.read("id_dsa")
        },
      },

    },
    watch: {
      css: {
        files: ['./css/sass/*.scss'],
        tasks: ['sass','autoprefixer','cssmin','sftp:css_upload'],
        options: {
          spawn: false,
        },
      },
      svg: {
        files:['./icons/svg/*.svg'],
        tasks: ['svgstore'],
        options: {
          spawn: false,
        },
      },
      deploy: {
        files: ['web/**'],
        tasks: ['sftp:upload_dev'],
        options: {
          spawn: false,
        },
      },
      configFiles: {
        files: [ 'Gruntfile.js' ],
        options: {
          reload: true
        }
      },
    },
  });
 // on watch events configure sftp.test.files to only run on changed file
 grunt.event.on('watch', function(action, filepath) {
  grunt.config('sftp.upload_dev.files', {"./": filepath});
});
  // Load the plugins
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-svgstore');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-ssh');

  // Default task(s).
  grunt.registerTask('default', ['watch']);
  grunt.registerTask('deploy', ['sshexec:stop_server','sftp:upload','sshexec:start_server']);

};