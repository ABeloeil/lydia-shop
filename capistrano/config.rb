# config valid only for current version of Capistrano
lock '3.5.0'

set :application, 'lydia-shop'
set :deploy_to, '/var/www/lydia-shop'
set :repo_url, 'git@github.com:ABeloeil/lydia-shop.git'
set :ssh_user, 'deploy'

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
set :format_options, command_output: true, log_file: 'var/logs/capistrano.log', color: :auto, truncate: :auto

# Default value for :log_level is :debug
set :log_level, :info

# Composer
set :composer_install_flags, '--no-dev --prefer-dist --no-interaction --quiet --optimize-autoloader'

# Default value for :linked_files is []
set :linked_files, %w{app/config/parameters.yml}

# Default value for linked_dirs is []
set :linked_dirs, %w{vendor node_modules var/logs}

# Remove app_dev.php & config.php during deployment
set :controllers_to_clear, ["app_*.php", "config.php"]

set :keep_releases, 3

namespace :deploy do
    after :cleanup, "build_theme"
end
