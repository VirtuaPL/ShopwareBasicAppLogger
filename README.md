# Virtua Shopware App Logger

### Description
This bundle contains fully functional logger for Shopware Applications.

------------

### Requirements
- PHP >= 8.0
- Symfony 6
- ShopwareShop Entity

------------

### Installation
- Add bundle repository to composer.json
```json
"virtua/shopware-app-logger-bundle": "^1.0"
```
- Add bundle to bundles.php
```php
Virtua\ShopwareAppLoggerBundle\VirtuaShopwareAppLoggerBundle::class => ['all' => true]
```
- Add bundle routes to routes.yaml
```yaml
shopware_app_logger_bundle_routes:
    resource: "@VirtuaShopwareAppLoggerBundle/Resources/config/routes.yaml"
```
- Create new file ```config/packages/virtua_shopware_app_logger.yaml```, with data:
```yaml
imports:
    - { resource: '@VirtuaShopwareAppLoggerBundle/Resources/config/config.yml' }
```
- Run migrations ```bin/console doctrine:migrations:migrate```

------------

### Usage

#####Writing
This bundle is fully functional right after installation. To create new log, use **log()** method from **Logger** service. As a paremeter you have to provide **LoggerData** object, which can be found in **Util** directory.

Example log() usage:
```php
use Virtua\ShopwareAppLoggerBundle\Service\Logger;
use Virtua\ShopwareAppLoggerBundle\Util\LoggerData;

/* ... */

public function __construct(Logger $logger)
{
	$this->logger = $logger;
}

/* ... */

public function exampleFunction(): void
{
	$loggerData = new LoggerData($shopId);
	$loggerData->setErrorMessage("Your error message");
	$loggerData->setErrorCode(404);   //This is optional, default code is 400
	$this->logger->log($loggerData);
}
```

#####Reading
Logs are displayed in **/logs/list/{shopId}** route, implemented in **AppLoggerController**
To add this into menu in your Shopware, you need to add new **module** in your **app** **manifest**.

Example module in manifest.xml:
```xml
<module name="logsModule"
    source="https://your_app_url/logs/list"
    parent="sw-extension"
    position="50"
>
    <label>Logs</label>
    <label lang="de-DE">Logs</label>
    <label lang="pl-PL">Logi</label>
</module>
```layed in **/logs/list/{shopId}** route, implemented in **AppLoggerController**