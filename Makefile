execute_dev_checks: check_security test check_code_style

check_security:
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

#docker part is wip
build_docker:
	docker build . -t exerclist

run_docker:
	docker run -p 8000:8000 exerclist
