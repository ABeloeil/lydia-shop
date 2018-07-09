server '51.15.251.174', user: fetch(:ssh_user), port: 22, roles: %w{web}

ask :branch, 'master'
set :symfony_env, 'prod'

set :ssh_options, {
    forward_agent: true,
    compression: false
}
