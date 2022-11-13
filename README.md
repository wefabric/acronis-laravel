# Acronis API - Laravel
Simple implementation of the Acronis PHP library within Laravel

## Installation
```bash
composer require wefabric/acronis-laravel
```

## Usage

Register a third-party application as an API client via the management console of the cloud platform in Acronis.
Copy the domain, client id and client secret and set them in the environment file as followed:

```
ACRONIS_URL=
ACRONIS_CLIENT_ID=
ACRONIS_CLIENT_SECRET=
```

Then it is possible to call the API as followed

```php
    use Wefabric\Acronis\AcronisClient;
    use Wefabric\Acronis\UrlResolver;
    use Wefabric\AcronisLaravel\CachedCredentials;

    $credentials = CachedCredentials::make(config('acronis.client_id'), config('acronis.client_secret'));
    $urlResolver = new UrlResolver(config('acronis.domain_url'));

    $acronis = new AcronisClient($urlResolver, $credentials);
    $alertsResponse = $acronis->getClient()->get('/api/alert_manager/v1/alerts');

    $alertsResponse->json();
```
## Config
To publish the config file, run the following command
```bash
php artisan vendor:publish --provider="Wefabric\AcronisLaravel\Providers\AcronisLaravelServiceProvider"
```
## License
Wefabric Acronis Laravel is open-sourced software licensed under the MIT license.



