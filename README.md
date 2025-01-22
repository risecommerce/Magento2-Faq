## Risecomemrce Magento 2 FAQ Extension
[Magento 2 Products FAQ Free Extension](https://risecommerce.com/store/magento2-products-faq.html) extension for Magento 2 assists customers to find the common inquiries on the knowledge base and faq lists. The module allows the admin to add questions and answers and list them on the front end with Tabs / Categories.

For more details about this extension, visit the [Magento 2 Products FAQ Free Extension](https://risecommerce.com/store/magento2-products-faq.html).

If you're looking to enhance your Magento store further, consider hiring a [dedicated Magento developer](https://risecommerce.com/hire-dedicated-magento-developer.html).

For support or inquiries, please visit our [contact page](https://risecommerce.com/contact).

## Support: 
version - 2.3.x, 2.4.x

## How to install Extension

Method I)

1. Download the archive file.
2. Unzip the file
3. Create a folder [Magento_Root]/app/code/Risecommerce/Faq
4. Drop/move the unzipped files to directory '[Magento_Root]/app/code/Risecommerce/Faq'

Method II)

Using Composer 

composer require risecommerce/magento-2-faq-extension:1.0.1

### Enable Extension:
- php bin/magento module:enable Risecommerce_Faq
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush

### Disable Extension:
- php bin/magento module:disable Risecommerce_Faq
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush
