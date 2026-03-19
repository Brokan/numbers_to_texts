##Tests
Run:
`php vendor/bin/phpunit`

## PHPStan
Run with:
`composer phpstan`
`php vendor/bin/phpstan analyse --memory-limit=1G`

##Code style fixer
Check for differences:
`composer cs-check`
`php vendor/bin/php-cs-fixer fix --dry-run --diff`

Make code style fixes:
`composer cs-fix`
`php vendor/bin/php-cs-fixer fix`