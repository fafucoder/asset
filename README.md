# Asset
Asset类的目的是前端资源的注册器，目的是为了管理资源依赖

## Install
```php
$ composer install dawn/Asset
```

## Userage
```php
$manager = AssetManager::getInstance();
$manager->register(array(
    'jquery' => array(
        'name' => 'jquery',
        'url' => 'http://localhost/examples/',
        'js' => array('jquery.min.js'),
        'css' => array('jquery.min.css'),
    ),
    'bootstrap' => array(
        'name' => 'bootstrap',
        'url' => 'http://localhost/examples/',
        'js' => array('bootstrap.min.js'),
        'css' => array('bootstrap.min.css'),
        'dependency' => array('jquery'),
    ),
));

$manager->enqueue('bootstrap');
```

## License

This project is under MIT License. See the [LICENSE](https://github.com/fafucoder/asset/blob/master/LICENSE) file for the full license text.

