@servers(['deploy' => ['root@209.126.81.131']])

@setup
    $repository = 'git@github.com:anilshr25/mamaghar-web.git';
    $releases_dir = '/var/www/html/mamaghar/releases';
    $app_dir = '/var/www/html/mamaghar';
    $live_dir = '/var/www/html/mamaghar/current';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@macro('deploy', ['on' => ['deploy'], 'parallel' => true])
    clone_repository
    update_symlinks
    run_composer
    update_permissions
    release_deployment
    clean_old_releases
    deploy_portal
@endmacro

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    ln -nfs {{ $app_dir }}/storage/framework/views {{ $new_release_dir }}/storage/framework/views
    ln -nfs {{ $app_dir }}/storage/framework/cache {{ $new_release_dir }}/storage/framework/cache
    ln -nfs {{ $app_dir }}/storage/framework/sessions {{ $new_release_dir }}/storage/framework/sessions
    ln -nfs {{ $app_dir }}/storage/logs {{ $new_release_dir }}/storage/logs
    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer update
@endtask


@task('update_permissions')
    echo 'Updating permission'
    cd {{ $new_release_dir }}
    chmod -R 775 {{ $new_release_dir }}
    chown -R www-data:www-data {{ $new_release_dir }} -h
@endtask

@task('release_deployment')
    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('migrate_db')
    echo 'Running Migration'
    cd {{ $live_dir }}
    php artisan migrate --force --no-interaction
    php artisan db:seed --class=EmailTemplateSeeder --force --no-interaction
    {{-- php artisan db:seed --force --no-interaction --}}
@endtask

@task('restart_cron_services')
    echo "Restarting Services"
    cd {{ $live_dir }}
    php artisan queue:restart
    php artisan queue:retry all
    sudo service cron restart
    php artisan config:clear
    php artisan config:cache
    php artisan optimize:clear
    php artisan optimize
    composer dump
    echo "Deployment complete"
@endtask

@task('clean_old_releases')
    # This will list our releases by modification time and delete all but the 3 most recent.
    @if (!empty($releases_dir) && $releases_dir != '/')
        purging=$(ls -dt {{ $releases_dir }}/* | tail -n +8);
        if [ "$purging" != "" ]; then
        echo Purging old releases: $purging;
        rm -rf $purging;
        else
        echo "No releases found for purging at this time";
        fi
    @endif
@endtask

@task('deploy_portal')
    echo 'Updating portal'
    cd /var/www/html/mamaghar
    rm -rf portal
    mkdir portal
    aws s3 sync s3://mamaghar.com.np/portal portal --delete --endpoint-url=https://s3.ap-southeast-1.wasabisys.com
@endtask
