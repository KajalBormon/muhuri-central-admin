#!/bin/sh

ssh -o StrictHostKeyChecking=no $USER@$HOST << 'ENDSSH'
  set -e  # Exit immediately if any command fails

  # Load NVM and use Node.js v22.14.0
  export NVM_DIR="$HOME/.nvm"
  [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
  nvm use 22.14.0

  cd /var/www/html/muhuri-web-central-admin/
  echo "$PWD"

  git stash -u
  git pull
  echo "Pulled latest changes"

  composer install --no-interaction --prefer-dist --optimize-autoloader
  composer update --no-interaction
  echo "Installed composer dependencies"

  echo "============================Removed old node_modules============================"
  sudo rm -rf node_modules/

  echo "============================Install node_modules============================"
  # Use the absolute paths
  #  /home/ubuntu/.nvm/versions/node/v20.19.0/bin/npm install
  #  /home/ubuntu/.nvm/versions/node/v20.19.0/bin/npm run build
  npm install
  npm run build

  ln -s /var/www/html/muhuri-web-central-admin/public/media/ /var/www/html/muhuri-web-central-admin/public/build/
  echo "Installed npm dependencies"
  echo "============================npm build done============================"

  php artisan migrate --no-interaction --force
  echo "============================migrated============================"

  sudo systemctl reload nginx
  echo "Deployed!"
ENDSSH
