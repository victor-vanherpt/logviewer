<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:codibit/logviewer.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('linode1.vanherpt.net')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/logviewer');

// Tasks

task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

task('yarn-encore', function () {
    cd('{{release_path}}');
    run('./node_modules/.bin/encore production');
});

after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'yarn-encore');