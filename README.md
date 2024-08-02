# Doris Module Configuration

## Overview

This document provides a step-by-step guide on configuring the Doris modules in Magento. Each step is illustrated with screenshots to help you navigate through the configuration process.

## Steps

### Step 1: Navigate to Stores

Go to `Stores -> Configuration` in the Magento admin panel.

![Step 1](./screenshots/Screenshot_from_2024-07-30_08-14-50.png)

### Step 2: Access Doris Module Configuration

Under `Configuration`, scroll down to find the `DORIS` section. Click on `Setup`.

![Step 2](./screenshots/Screenshot_from_2024-07-30_08-14-59.png)

### Step 3: Configure Doris API Keys

Enter the `Doris API Key` and `Doris Secret Key` provided to you.

![Step 3](./screenshots/Screenshot_from_2024-07-30_08-15-08.png)

### Step 4: Configure Catalog Integrator

Under the `Catalog Integrator` section, map the website categories to the Doris categories.

![Step 4](./screenshots/Screenshot_from_2024-07-30_08-15-18.png)

### Step 5: Configure Doris Widget

In the `Doris Widget` section, configure the widget settings such as `Enabled`, `Color`, and `Splash Image`.

![Step 5](./screenshots/Screenshot_from_2024-07-30_08-15-31.png)

### Step 6: Category Association

Map the website categories to the Doris categories.

![Step 6](./screenshots/Screenshot_from_2024-07-30_08-15-40.png)

### Step 7: Select Website Scope

To integrate a specific website, select the desired website from the `Scope` dropdown.

![Step 7](./screenshots/Screenshot_from_2024-07-30_08-15-57.png)

### Step 8: Start Integration

Click on `Start Integration` to begin exporting products to Doris.

## Additional Information

### Integration Logs

Every time the user clicks on `Start Integration`, a record is created in the `doris_export_pipeline` table, which logs the integrations. Additionally, there is a table called `doris_export_pipeline_item` that contains all the products that have been integrated with Doris. If you want a product to be reprocessed, you need to delete its SKU from this table.

### Compatibility

The module is compatible with the Luma theme. To add the script for the button, the developer should use the block:

```xml
<block before="-" class="LeandroRosa\DorisWidget\Block\InjectButton" name="product.doris_inject_button" template="LeandroRosa_DorisWidget::inject-button.phtml" />
```

This block is originally displayed on the product page:

```xml
<referenceContainer name="product.info.extrahint">
    <block before="-" class="LeandroRosa\DorisWidget\Block\InjectButton" name="product.doris_inject_button" template="LeandroRosa_DorisWidget::inject-button.phtml" />
</referenceContainer>
```

However, you can add the block to any position and page you prefer.

## Configurations

To set the module to developer mode, run the following shell script:

```sh
#!/bin/bash

php bin/magento deploy:mode:set developer
php bin/magento config:set dev/template/allow_symlink 1
php bin/magento config:set admin/security/use_form_key 0
php bin/magento config:set admin/security/admin_account_sharing 1
php bin/magento config:set cms/wysiwyg/enabled disabled
php bin/magento config:set web/seo/use_rewrites 1
php bin/magento cache:flush
php bin/magento cache:clean
```
```
