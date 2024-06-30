@servers([ 'production' => ['enaya@178.62.228.21'] ])

@setup
    $release_dir = '/home/enaya/public_html/mazadat';
@endsetup

@story('deploy')
    clone_repository_pro
    debug
    {{-- setup_symlinks --}}
    {{-- run_composer --}}
    {{-- update_symlinks --}}
    {{-- optimize --}}
    {{-- cleanup --}}
@endstory

@task('clone_repository_pro' , ['on' => 'production'])
    cd {{ $release_dir }}
    git checkout main   
    git reset --hard HEAD
    git pull origin main
    {{-- composer update --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs --}}
    {{-- php artisan optimize:clear --}}
@endtask


@task('debug')
    php -v
    ls -la {{ $release_dir }}
@endtask

@task('setup_symlinks')
echo "* Linking .env file to new release dir ({{ $app_dir }}/.env -> {{ $release_dir }}/.env) *"
ln -nfs {{ $app_dir }}/.env {{ $release_dir }}/.env

if [ -f {{ $release_dir }}/storage ]; then
echo "* Moving existing storage dir *"
mv {{ $release_dir }}/storage {{ $release_dir }}/storage.orig 2>/dev/null
fi

echo "* Linking storage directory to new release dir ({{ $app_dir }}/storage -> {{ $release_dir }}/storage) *"
ln -nfs {{ $app_dir }}/storage {{ $release_dir }}/storage
@endtask

@task('verify_install')
echo "* Verifying install ({{ $release_dir }}) *"
cd {{ $release_dir }}
php artisan --version
@endtask

@task('run_composer')
cd {{ $release_dir }};
composer update --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs;
@endtask

@task('update_symlinks')
ln -nfs {{ $release_dir }} {{ $app_dir }};
@endtask

@task('migrate_database')
cd {{ $release_dir }};
php artisan migrate:fresh --seed --force;
@endtask

@task('optimize')
cd {{ $release_dir }};
php artisan optimize;
@endtask

@task('cleanup')
cd {{ $releases_dir }};
ls -t | tail -n +2 | xargs rm -rf;
@endtask

@finished
    echo 'Deployment successful!';
@endfinished

{{-- @task('list', ['on' => 'develop'])
    cd /home/hashem/public_html/imed.matrixclouds.net
    ls
@endtask

@task('composer', ['on' => 'develop'])
    cd {{ $app_dir }}
    composer -V
@endtask --}}
