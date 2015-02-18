<?php
use \Pimple\Container as Pimple;
use \Opensoft\SimpleSerializer as OSS;
use \Doctrine\ORM as ORM;
use \Doctrine\DBAL\Types\Type as Type;
use \Doctrine\DBAL\Event\Listeners\MysqlSessionInit;
use \Doctrine\StdErrSQLLogger;

return call_user_func(function () {
    require __DIR__ . '/vendor/autoload.php';
    
    $SL = new Pimple();

    $SL['URL'] = function () {
        $PATH = dirname($_SERVER['SCRIPT_NAME']);
        if (in_array($PATH, array('\\', '/'))) {
            $PATH = '';
        }
        return $PATH;
    };
    $SL['SCRIPT_URL'] = function () use ($SL) {
        return $SL['URL'] . '/index.php';
    };
    $SL['LOCAL_LIB'] = function () {
        return __DIR__;
    };
    $SL['LOCAL_HOME'] = function () use ($SL) {
        return realpath($SL['LOCAL_LIB'] . '/..');
    };
    $SL['LOCAL_APPS'] = function () use ($SL) {
        return realpath($SL['LOCAL_HOME'] . '/apps');
    };
    $SL['LOCAL_DATA'] = function () use ($SL) {
        return realpath($SL['LOCAL_HOME'] . '/data');
    };
    $SL['LOCAL_HTML'] = function () use ($SL) {
        return realpath($SL['LOCAL_HOME'] . '/../public_html');
    };
    $SL['PUBLIC_HTML'] = function () use ($SL) {
        return '';
    };
    $SL['LOCAL_ASSETS'] = function () use ($SL) {
        return realpath($SL['LOCAL_HTML'] . '/assets');
    };
    $SL['PUBLIC_ASSETS'] = function () use ($SL) {
        return $SL['PUBLIC_HTML'] . '/assets';
    };
    $SL['LOCAL_UPLOADS'] = function () use ($SL) {
        return realpath($SL['LOCAL_HTML'] . '/uploads');
    };
    $SL['PUBLIC_UPLOADS'] = function () use ($SL) {
        return $SL['PUBLIC_HTML'] . '/uploads';
    };

    $SL['PATHS'] = function ($string) use ($SL) {
        return array(
            '%URL%'            => $SL['URL'],
            '%SCRIPT_URL%'     => $SL['SCRIPT_URL'],
            '%LOCAL_LIB%'      => $SL['LOCAL_LIB'],
            '%LOCAL_HOME%'     => $SL['LOCAL_HOME'],
            '%LOCAL_APPS%'     => $SL['LOCAL_APPS'],
            '%LOCAL_DATA%'     => $SL['LOCAL_DATA'],
            '%LOCAL_HTML%'     => $SL['LOCAL_HTML'],
            '%PUBLIC_HTML%'    => $SL['PUBLIC_HTML'],
            '%LOCAL_ASSETS%'   => $SL['LOCAL_ASSETS'],
            '%PUBLIC_ASSETS%'  => $SL['PUBLIC_ASSETS'],
            '%LOCAL_UPLOADS%'  => $SL['LOCAL_UPLOADS'],
            '%PUBLIC_UPLOADS%' => $SL['PUBLIC_UPLOADS']
        );
    };

    $SL['fixPaths'] = $SL->protect(function ($string) use ($SL) {
        $paths = $SL['PATHS'];
        $search = array();
        $replace = array();
        foreach($paths as $s=>$r) {
            $search[]  = $s;
            $replace[] = $r;
        }
        return str_replace($search, $replace, $string);
    });

    $SL['timer'] = new \Timer();

    $SL['config'] = function () use ($SL) {
        return new \YamlSource($SL['LOCAL_APPS'] . '/configs/config.yml', $SL['PATHS']);
    };

    $SL['setTimezone'] = function () use ($SL) {
        date_default_timezone_set($SL['config']['app']['timezone']);
    };

    $SL['serializer'] = function () use ($SL) {
        $cacheDriver = null;
        if ( ! $SL['config']['app']['debug']) {
            $cacheDriver = new OSS\Metadata\Cache\FileCache($SL['LOCAL_DATA'] . '/cache/serialization');
        }
        return new OSS\Serializer(
            new OSS\Adapter\MyArrayAdapter(
                new OSS\Metadata\MetadataFactory(
                    new OSS\Metadata\Driver\YamlDriver(
                        new OSS\Metadata\Driver\FileLocator(
                            array(
                                'App\\Model\\Entities' => $SL['LOCAL_LIB'] . '/App/Model/Entities',
                                '\\'                   => $SL['LOCAL_LIB']
                            )
                        )
                    ),
                    $cacheDriver,
                    $SL['config']['app']['debug']
                )
            ),
            new OSS\Adapter\JsonAdapter()
        );
    };

    $SL['entityManager'] = function () use ($SL) {
        $SL['setTimezone'];
        $eventManager = new \Doctrine\Common\EventManager();
        $eventManager->addEventListener(
            ORM\Events::loadClassMetadata,
            new \Doctrine\Extensions\TablePrefix($SL['config']['app']['database']['tableprefix'])
        );

        $configuration = ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            array($SL['LOCAL_LIB'] . "/App/Model/Entities"),
            $SL['config']['app']['debug']
        );
        if ($SL['config']['app']['sqlLog']) {
            $configuration->setSQLLogger(new StdErrSQLLogger());
        }
        $configuration->addEntityNamespace('App', 'App\\Model\\Entities');

        $em = ORM\EntityManager::create(
            $SL['config']['app']['database']['config'],
            $configuration,
            $eventManager
        );
        
        Type::addType('kdate', 'Doctrine\Types\KDateType');

        $platform = $em->getConnection()->getDatabasePlatform();
        $platform->markDoctrineTypeCommented(Type::getType('kdate'));
        $platform->markDoctrineTypeCommented(Type::getType('date'));
        $platform->markDoctrineTypeCommented(Type::getType('datetime'));
        $platform->markDoctrineTypeCommented(Type::getType('datetimetz'));
               
        return $em;
    };

    $SL['assets'] = function ($SL) {
        return $SL['config']['app']['assets'];
    };

    $SL['app'] = function () use ($SL) {
        $SL['setTimezone'];
        $config = $SL['config']['slim'];
        $view = new \Slim\Views\Twig();
        $view->parserOptions = array(
            'debug' => $SL['config']['app']['debug'],
            'cache' => $SL['LOCAL_DATA'] . '/cache/templates'
        );
        $view->parserExtensions = array(
            new \Slim\Views\TwigExtension()
        );
        $config['view']           = $view;
        $config['templates.path'] = $SL['LOCAL_APPS'] . '/templates';
        $app = new \Slim\Slim($config);
        if (is_array($SL['config']['app']['routes'])) {
            foreach ($SL['config']['app']['routes'] as $mapTo=>$routes) {
                $SL['routerFactory']($app, $mapTo, $routes);
            }
        }
        return $app;
    };

    $SL['routerFactory'] = $SL->protect(function(\Slim\Slim $slim, $mapTo, $routes) use ($SL) {
        array_walk($routes, function($route, $key) use ($SL, $slim, $mapTo) {
            if ( ! isset($route['active']) || $route['active'] != true) return;
            $callback = null;
            if (isset($route['callback'])) {
                $callback = $route['callback'];
            } elseif (isset($route['controller']) && isset($route['action'])) {
                $callback = function() use ($SL, $route) {
                    $argv = func_get_args();
                    $controller = $SL['controllerFactory']($route['controller']);
                    $action = $route['action'];
                    $controller->beforeDispatch();
                    $controller->$action($argv);
                    $controller->afterDispatch();
                };
            }
            if ($callback == null) throw new \RuntimeException('Route callback is invalid!');
            $pattern = $route['pattern'];
            $routeMapping = $slim->map($mapTo . $pattern, $callback);
            $routeMapping->setName($key);
            // Slim version <= 2.5:
            /*array_walk($route['methods'], function(method) use ($routeMapping) {
                $routeMapping->via($method);
            });*/
            // Slim version >= 2.5:
            $routeMapping->via($route['methods']);
        });
    });

    $SL['getControllerClassName'] = $SL->protect(function($name) {
        return 'App\\Controllers\\' . ucfirst($name);
    });
    $SL['controllerFactory'] = $SL->protect(function($name) use ($SL) {
        $className       = $SL['getControllerClassName']($name);
        $application     = $SL['app'];
        $serializer      = $SL['serializer'];
        $timer           = $SL['timer'];
        $globalViewScope = array(
            'assets'          => $SL['assets'],
            'URL'             => $SL['URL'],
            'SCRIPT_URL'      => $SL['SCRIPT_URL'],
            'PUBLIC_ASSETS'   => $SL['PUBLIC_ASSETS'],
            'PUBLIC_UPLOADS'  => $SL['PUBLIC_UPLOADS']
        );
        return new $className($application, $serializer, $timer, $globalViewScope);
    });

    $SL['getEntityClassName'] = $SL->protect(function($name) {
        return 'App\\Entities\\' . ucfirst($name);
    });

    $SL['markdownParser'] = function($SL) {
        return new \MarkdownParser();
    };

    $SL['url'] = function() use ($SL) {
        return new \SlimURL($SL['app']);
    };

    $SL['diff'] = function() {
        return new \Diff;
    };

    $SL['users'] = function() use ($SL) {
        return new \App\Services\Users($SL['entityManager']);
    };

    $SL['articles'] = function() use ($SL) {
        return new \App\Services\Articles($SL['entityManager'], $SL['diff']);
    };

    return $SL;
});
