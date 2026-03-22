# Setup
Require:
 - git
 - php8.4
 - composer
 - docker (optional)
1. Clone project `git clone https://github.com/Brokan/numbers_to_texts.git`
2. Go to /numbers_to_texts
3. Create local .env. Run `cp .env.example .env`
4. Run `composer install`
5. Numbers are storing in file `storage\app\stack.json`. Check that file and whole folder has write rights.
6. To run project, can `php artisan serve`, localhost will be shown like:
```
 Server running on [http://127.0.0.1:8000].
```
By this link can start use API endpoints.

7. Or can run docker:
`docker compose up --build`
URL will be `http://numbers.local`

7.1. Probably to `hosts` need to add
```
127.0.0.1 numbers.local
```

# Endpoints
## Numbers set
Endpoint POST `/api/numbers`
Payload params:
 - `number` - Positive integer number.
Payload example:
```
{
    "number" : 5
}
```

Response must have 201 code.
Response example:
```
{
    "success": true,
    "message": "Number added to stack"
}
```

## Numbers get
Endpoint GET `/api/numbers?language=lv`
Request params:
 - `language` - (optional) Language of number in text format "en" (default) or "lv".

Response example:
```
{
    "success": true,
    "number": 5,
    "text": "pieci"
}
```


# Tests and code checks
## Tests
Run:
`php vendor/bin/phpunit`

## PHPStan
Run with:
`composer phpstan`
`php vendor/bin/phpstan analyse --memory-limit=1G`

## Code style fixer
Check for differences:
`composer cs-check`
`php vendor/bin/php-cs-fixer fix --dry-run --diff`

Make code style fixes:
`composer cs-fix`
`php vendor/bin/php-cs-fixer fix`
