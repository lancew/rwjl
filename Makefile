.PHONY: dev scan tidy

dev:
	@php -S localhost:8000

scan:
	@php vendor/bin/phpstan analyse index.php lib controllers views

tidy:
	@php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix ./