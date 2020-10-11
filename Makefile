execute_dev_checks: security_check test check_code_style

security_check:
	symfony check:security

test:
	bin/phpunit

check_code_style:
	php vendor/bin/phpcs --standard=psr12 src/ -n

fix_code_style:
	php vendor/bin/phpcbf --standard=psr12 src/ -n

clear_cache:
	rm -rf var/cache/*

migrate:
	php bin/console doctrine:migrations:migrate -n

build_docker:
	docker build . -t exerclist

app_container_run:
	docker kill exerclist || true
	docker run -p 8000:8000 --network=exerclist --name exerclist -d --mount type=bind,source=/home/z/projects/exerclist,target=/var/www/exerclist --rm exerclist

mysql_container_run:
	docker stop exerclist-mysql || true
	docker run --name exerclist-mysql -e MYSQL_USER='z' -e MYSQL_PASSWORD='z' -e  MYSQL_DATABASE='exerclist' -e MYSQL_ROOT_PASSWORD='z' -p 33060:33060 -d --network=exerclist --mount type=volume,source=mysql-data-exerclist,target=/var/lib/mysql --rm mysql:5

run_docker: mysql_container_run app_container_run

stop_docker:
	docker stop exerclist exerclist-mysql

create_docker_network:
	docker network create exerclist
