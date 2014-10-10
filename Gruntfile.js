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
          './css/build/unprefixed/print.css': './css/sass/print.scss'
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
'sftp-deploy': {
  build: {
    auth: {
      host: '192.168.2.106',
      port: 300,
      authKey: 'privateKey'
    },
    cache: 'sftpCache.json',
    src: 'web',
    dest: '/var/schlangennest',
   // exclusions: ['/path/to/source/folder/**/.DS_Store', '/path/to/source/folder/**/Thumbs.db', 'dist/tmp'],
    serverSep: '/',
    concurrency: 4,
    progress: false
  }
},
sftp: {
  upload: {
    files: {
      "./": ["./web/*"]
    },
    options: {
      path: '/var/schlangennest',
      host: '<%= secret.host %>',
      port: '<%= secret.port %>',
      username: '<%= secret.username %>',
      privateKey: grunt.file.read("id_dsa"),
      showProgress: true
    }
  }
},
sshexec: {
  test: {
    command: 'uptime',
    options: {
      host: '<%= secret.host %>',
      port: '<%= secret.port %>',
      username: '<%= secret.username %>',
      privateKey: grunt.file.read("id_dsa")
    }
  }
},
    watch: {
      css: {
        files: ['./css/sass/*.scss'],
        tasks: ['sass','autoprefixer','cssmin'],
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
      configFiles: {
        files: [ 'Gruntfile.js' ],
        options: {
          reload: true
        }
      },
    },
  });

  // Load the plugins
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-svgstore');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-ssh');
  grunt.loadNpmTasks('grunt-sftp-deploy');

  // Default task(s).
  grunt.registerTask('default', ['watch']);

};