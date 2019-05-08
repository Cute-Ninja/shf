create_db:
	php bin/console doctrine:database:drop --force --if-exists --env=$(ENV)
	php bin/console doctrine:database:create --env=$(ENV)
	php bin/console doctrine:schema:create --env=$(ENV)

load_db: create_db
	php bin/console hautelook:fixtures:load --append