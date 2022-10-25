#!/bin/bash

# run composer install in api folder
docker-compose exec php bash -c "cd api && composer i --no-scripts"
docker-compose exec php php bin/console cache:clear --no-warmup

#lexik jwt keys
docker-compose exec php php bin/console lexik:jwt:generate-keypair --skip-if-exists

# recreate copytrading database
docker-compose exec php php api/bin/console doctrine:database:drop --if-exists --force
docker-compose exec php php api/bin/console doctrine:database:create
docker-compose exec php php api/bin/console doctrine:migration:migrate --no-interaction --allow-no-migration
docker-compose exec php php api/bin/console doctrine:fixture:load
