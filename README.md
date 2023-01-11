# Custom Validation API

This project is an example of creating a custom validation API using Laravel. It provides a single endpoint /validate-payload that accepts a JSON payload and validates it using custom validation rules.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
- [PHP](https://secure.php.net/downloads.php) >= 8.1
- [Composer](https://getcomposer.org/)

### Installation
1. Clone the repository
```
    git clone https://github.com/ojsholly/laravel-custom-validation-api.git
```

2. Install dependencies
```
    composer install
```

3. Create the project environment file
```
   cp .env.example .env
```

4. Generate a new application key
   php artisan key:generate

### Usage
The **/validate-payload** endpoint accepts a JSON payload in the following format:

```
{
    "first_name": {
        "value": "John",
        "rules": "alpha|required"
    },
    "last_name": {
        "value": "Doe",
        "rules": "alpha|required"
    },
    "email": {
        "value": "example@example.com",
        "rules": "email"
    },
    "phone": {
        "value": "08175020329",
        "rules": "number"
    }
}
```

The available rules that can be used in the payload are:
- alpha - the value must be a string containing only alphabetical characters
- required - the value must not be empty
- email - the value must be a valid email address
- number - the value must be numeric

The validation engine supports multiple validation rules per key, separated by a pipe character (|).

If the validation passes, the endpoint returns a JSON response with a status key set to true. If the validation fails, the endpoint returns a JSON response with a status key set to false and an errors key containing an array of the validation errors.

### Testing
The project includes a PHPUnit test suite. To run the tests, execute the following command:
```
 php artisan test
```
