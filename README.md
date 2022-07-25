# Virtua Shopware Basic App Logger

### Description
This bundle contains fully functional logger for Shopware Applications. The application meets the Shopware quality guidelines and places the logs in default Shopware log_entry entity.

------------

### Requirements
- PHP >= 8.0
- Symfony 6
- ShopwareShop Entity

------------

### Installation
- Add bundle repository to composer.json
```json
"virtua/shopware-basic-app-logger-bundle": "^1.0"
```
- Add bundle to bundles.php
```php
Virtua\ShopwareBasicAppLoggerBundle\ShopwareBasicAppLoggerBundle::class => ['all' => true]
```
- Add bundle routes to routes.yaml
```yaml
shopware_app_logger_bundle_routes:
    resource: "@VirtuaShopwareBasicAppLoggerBundle/Resources/config/routes.yaml"
```
- Create new file ```config/packages/virtua_shopware_basic_app_logger.yaml```, with data:
```yaml
imports:
    - { resource: '@VirtuaShopwareBasicAppLoggerBundle/Resources/config/config.yml' }
```
- Run migrations ```bin/console doctrine:migrations:migrate```

------------

### Usage

#####Writing
This bundle is fully functional right after installation. To create new log, use **log()** method from **Logger** service. As a paremeter you have to provide **LoggerData** object, which can be found in **Util** directory.

Example log() usage:
```php
use Virtua\ShopwareBasicAppLoggerBundle\Service\Logger;
use Virtua\ShopwareBasicAppLoggerBundle\Util\LoggerData;

/* ... */

public function __construct(Logger $logger)
{
	$this->logger = $logger;
}

/* ... */

public function exampleFunction(): void
{
	$loggerData = new LoggerData($shopId);
	$loggerData->setMessage("shopware.app.error"); //Use your appication name to identify error in logEntry
	$loggerData->setLevel(404);   //This is optional, default code is 400
	$loggerData->setContext('Your Error message', $errorData ); //errorData is optional parameter to pass additional error informations as array
	$this->logger->log($loggerData);  
}
```

#####Reading
Logs are displayed in Shopware entity log_entry, available in Administration->System->Event Logs
