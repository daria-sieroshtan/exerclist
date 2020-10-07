execute_dev_checks: check_security test check_code_style

check_security:
	symfony check:security

test:
	bin/phpunit

check_code_style:
	php vendor/bin/phpcs --standard=psr12 src/ -n
