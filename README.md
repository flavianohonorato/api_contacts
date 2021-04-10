## About

The Api created with Laravel from contacts SPA ([visit here](https://github.com/flavianohonorato/spa_contacts))

## Installation
##### Requeriments
- PHP ^7.3|^8.0
- mbstring PHP Extension
- PDO Extension

```sh
$ git clone https://github.com/flavianohonorato/api_contacts
```

Do not forget to configure your database and the like in the .env configuration file.
After doing this, run the following command within your installation directory:
```sh
$ composer install
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```

## Resources
* To list all contacts (with pagination)
```
GET /api/v1/contacts?page=1 HTTP/1.1
Host: localhost:8000
```

* To add a contact
```
POST /api/v1/contacts HTTP/1.1
Content-Type: application/json
Host: localhost:8000
{
    "name": "jane Doe",
    "email": "jane@doe.com.br",
    "cpf": "000-111.222-33"
}
```

* To update a contact
```
PUT /api/v1/contacts/1 HTTP/1.1
Content-Type: application/json
Host: localhost:8000
{
    "name": "Jane Doe"
}
```

* To show a contact
```
GET /api/v1/contacts/1 HTTP/1.1
Host: localhost:8000
```

* To delete a contact
```
DELETE /api/v1/contacts/1 HTTP/1.1
Content-Type: application/json
Host: localhost:8000
```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
