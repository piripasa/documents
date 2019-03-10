#!/usr/bin/env bash

set -e
#sh ./scripts/docker.sh
# [ -f ".env.testing" ] || $(echo Please make an .env.testing file --env=testing; exit 1)
export $(cat .env.testing | grep -v ^# | xargs);
sudo docker-compose down
echo Starting services
sudo docker-compose up -d
echo Host: 127.0.0.1
until sudo docker-compose exec mysql mysql -h 127.0.0.1 -u $DB_USERNAME -p$DB_PASSWORD -D $DB_DATABASE --silent -e "show databases;"
do
  echo "Waiting for database connection..."
  sleep 5
done
echo "Installing dependencies"
sudo docker-compose exec php composer install
sudo docker-compose exec php chgrp -R www-data storage
sudo docker-compose exec php chmod -R ug+rwx storage
rm -f public/storage
sudo docker-compose exec php ln -s /var/www/html/storage/app/public /var/www/html/public/storage
echo "Migrating database"
rm -f bootstrap/cache/*.php
sudo docker-compose exec php php artisan migrate --env=testing && echo "Database migrated"
echo "Installing node dependencies"
sudo docker-compose exec php npm install
sudo docker-compose exec php npm run prod
#echo "Unit testing..."
#sudo docker-compose exec php vendor/bin/phpunit
