SEO module for Yii 2
========================


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require infoweb-internet-solutions/yii2-cms-seo "*"
```

or add

```
"infoweb-internet-solutions/yii2-cms-seo": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

Your backend configuration as follows:

```php
'modules' => [
    ...
    'seo' => [
        'class' => 'infoweb\seo\Module',
    ],
],
```

Import the translations and use category 'infoweb/seo':
```
yii i18n/import @infoweb/seo/messages
```

To use the module, execute yii migration
```
yii migrate/up --migrationPath=@vendor/infoweb-internet-solutions/yii2-cms-seo/migrations
```

Configuration
-------------
All available configuration options are listed below with their default values.
___
##### allowContentDuplication (type: `boolean`, default: `true`)
If this option is set to `true`, the `duplicateable` jquery plugin is activated on all translateable attributes.
___
