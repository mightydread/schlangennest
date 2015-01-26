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
      admin : {
        files: {
          './web/includes/icons_admin.svg': ['./icons/svg/admin_*.svg'],
        },
      },
      lager : {
        files: {
          './web/includes/icons_lager.svg': ['./icons/svg/lager_*.svg'],
        },
      },
      door : {
        files: {
          './web/includes/icons_door.svg': ['./icons/svg/door_*.svg'],
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
          path: '/var/www/media/css',
          srcBasePath: 'web/media/css/',
          host: '<%= secret.hal.host %>',
          port: '<%= secret.hal.port %>',
          username: '<%= secret.hal.username %>',
          // password : '<%= secret.hal.pass %>',
          privateKey: grunt.file.read("id"),
          showProgress: true
        },
      },
      upload: {
        files: {
          "./": ["web/**"],
        },
        options: {
          path: '/var/www2',
          srcBasePath: 'web/',
          host: '<%= secret.bob.host %>',
          port: '<%= secret.bob.port %>',
          username: '<%= secret.bob.username %>',
          privateKey: grunt.file.read("id"),
          showProgress: true
        }
      },
      upload_dev: {
        files: {
          "./": ["web/**"],
        },
        options: {
          path: '/var/www',
          srcBasePath: 'web/',
          host: '<%= secret.hal.host %>',
          port: '<%= secret.hal.port %>',
          username: '<%= secret.hal.username %>',
          // password : '<%= secret.hal.pass %>',
          privateKey: grunt.file.read("id"),
          showProgress: true
        }
      }
    },
    sshexec: {
      // stop_server: {
      //   command: 'sudo service apache2 stop',
      //   options: {
      //     host: '<%= secret.bob.host %>',
      //     port: '<%= secret.bob.port %>',
      //     username: '<%= secret.bob.username %>',
      //     privateKey: grunt.file.read("id")
      //   },
      // },
      // start_server: {
      //   command: 'sudo service apache2 start',
      //   options: {
      //     host: '<%= secret.bob.host %>',
      //     port: '<%= secret.bob.port %>',
      //     username: '<%= secret.bob.username %>',
      //     privateKey: grunt.file.read("id")
      //   },
      // },
      permissions_dev: {
        command: 'sudo chown -R http:http /var/www && sudo find /var/www -type d -print0 | xargs -0 sudo chmod 775 && sudo find /var/www -type f -print0 | xargs -0 sudo chmod 664',
        options: {
          host: '<%= secret.hal.host %>',
          port: '<%= secret.hal.port %>',
          username: '<%= secret.hal.username %>',
          // password : '<%= secret.hal.pass %>',
          privateKey: grunt.file.read("id"),
        },
      },
      permissions: {
        command: 'sudo chown -R http:http /var/www2 && sudo find /var/www2 -type d -print0 | xargs -0 sudo chmod 775 && sudo find /var/www2 -type f -print0 | xargs -0 sudo chmod 664',
        options: {
          host: '<%= secret.hal.host %>',
          port: '<%= secret.hal.port %>',
          username: '<%= secret.hal.username %>',
          // password : '<%= secret.hal.pass %>',
          privateKey: grunt.file.read("id"),
        },
      },
    },
    watch: {
      css: {
        files: ['./css/sass/*.scss'],
        tasks: ['sass','autoprefixer','cssmin','sftp:css_upload','sshexec:permissions'],
        options: {
          spawn: false,
        },
      },
      svg_admin: {
        files:['./icons/svg/admin_*.svg'],
        tasks: ['svgstore:admin'],
        options: {
          spawn: false,
        },
      },
      svg_lager: {
        files:['./icons/svg/lager_*.svg'],
        tasks: ['svgstore:lager'],
        options: {
          spawn: false,
        },
      },
      svg_door: {
        files:['./icons/svg/door_*.svg'],
        tasks: ['svgstore:door'],
        options: {
          spawn: false,
        },
      },
      // upload_files: {
      //   files: ['web/**'],
      //   tasks: ['sftp:upload_dev','sshexec:permissions'],
      //   options: {
      //     spawn: false,
      //   },
      // },
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
  grunt.registerTask('deploy', ['sftp:upload','sshexec:permissions']);
  grunt.registerTask('dev_deploy', ['sftp:upload_dev','sshexec:permissions_dev']);
};