<?php
use \Opensoft\SimpleSerializer as OSS;
use \Doctrine\ORM as ORM;
use \Doctrine\DBAL\Types\Type as Type;
use \Doctrine\DBAL\Event\Listeners\MysqlSessionInit;
use \Doctrine\StdErrSQLLogger;
use \Zend\Permissions\Acl\Acl;
use \Zend\Permissions\Acl\Role\GenericRole as Role;
use \Zend\Permissions\Acl\Resource\GenericResource as Resource;

return call_user_func(function () {
    require __DIR__ . '/vendor/autoload.php';
    
    $SL = \ServiceLocator::getInstance();

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
    $SL['LOCAL_HOME'] = function ($SL) {
        return realpath($SL['LOCAL_LIB'] . '/..');
    };
    $SL['LOCAL_APPS'] = function ($SL) {
        return realpath($SL['LOCAL_HOME'] . '/apps');
    };
    $SL['LOCAL_DATA'] = function ($SL) {
        return realpath($SL['LOCAL_HOME'] . '/data');
    };
    $SL['LOCAL_HTML'] = function ($SL) {
        return realpath($SL['LOCAL_HOME'] . '/../public_html');
    };
    $SL['PUBLIC_HTML'] = function($SL) {
        return '';
    };
    $SL['LOCAL_ASSETS'] = function($SL) {
        return realpath($SL['LOCAL_HTML'] . '/assets');
    };
    $SL['PUBLIC_ASSETS'] = function ($SL) {
        return $SL['PUBLIC_HTML'] . '/assets';
    };
    $SL['LOCAL_UPLOADS'] = function ($SL) {
        return realpath($SL['LOCAL_HTML'] . '/uploads');
    };
    $SL['PUBLIC_UPLOADS'] = function ($SL) {
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

    $SL['session'] = function () use ($SL) {
        session_start();
        return new \Services\Session();
    };

    $SL['timer'] = new \Timer();

    $SL['factory'] = function () {
        return new \Services\Factory();
    };

    $SL['config'] = function($SL) {
        return new \YamlSource($SL['LOCAL_APPS'] . '/configs/config.yml', $SL['PATHS']);
    };

    $SL['hash'] = function ($SL) {
        return new \Hash('sha1', $SL['config']['app']['salt']);
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
                                'Hotel\\Entities' => $SL['LOCAL_LIB'] . '/Hotel/Entities',
                                '\\'              => $SL['LOCAL_LIB']
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
        // date_default_timezone_set($SL['config']['app']['timezone']);
        $eventManager = new \Doctrine\Common\EventManager();
        $eventManager->addEventListener(
            ORM\Events::loadClassMetadata,
            new \Doctrine\Extensions\TablePrefix($SL['config']['app']['database']['tableprefix'])
        );

        $configuration = ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            array($SL['LOCAL_LIB'] . "/Hotel/Entities"),
            $SL['config']['app']['debug']
        );
        if ($SL['config']['app']['sqlLog']) {
            $configuration->setSQLLogger(new StdErrSQLLogger());
        }
        $configuration->addEntityNamespace('Hotel', 'Hotel\\Entities');

        $em = ORM\EntityManager::create(
            $SL['config']['app']['database']['config'],
            /*array(
                'driver'        => $SL['config']['app']['database']['driver'],
                'host'          => $SL['config']['app']['database']['host'],
                'user'          => $SL['config']['app']['database']['user'],
                'password'      => $SL['config']['app']['database']['password'],
                'dbname'        => $SL['config']['app']['database']['database'],
                'charset'       => 'utf8',
                'driverOptions' => array(
                    1002 => 'SET NAMES utf8'
                )
            ),*/
            $configuration,
            $eventManager
        );
        
        
        Type::addType('money', 'Money\Doctrine2\MoneyType');
        Type::addType('kdate', 'Doctrine\Types\KDateType');

        $platform = $em->getConnection()->getDatabasePlatform();
        $platform->markDoctrineTypeCommented(Type::getType('money'));
        $platform->markDoctrineTypeCommented(Type::getType('kdate'));
        $platform->markDoctrineTypeCommented(Type::getType('date'));
        $platform->markDoctrineTypeCommented(Type::getType('datetime'));
        $platform->markDoctrineTypeCommented(Type::getType('datetimetz'));
        
        // $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('MoneyType','money');
        
        return $em;
    };

    $SL['reconnectToDB'] = $SL->protect(function () use ($SL) {
        $em = $SL['entityManager'];
        $em->getConnection()->close();
        return $em->getConnection()->connect();
    });
    

    $SL['assets'] = function ($SL) {
        return $SL['config']['app']['assets'];
    };

    $SL['app'] = function () use ($SL) {
        // date_default_timezone_set($SL['config']['app']['timezone']);
        $config = $SL['config']['slim'];
        $view = new \Slim\Views\Twig();
        $view->parserOptions = array(
            'debug' => $SL['config']['app']['debug'],
            'cache' => $SL['LOCAL_DATA'] . '/cache/templates'
        );
        $view->parserExtensions = array(
            new \Slim\Views\TwigExtension(),
            //new \Slim\Views\MyTwigExtension(),
        );
        $config['view']           = $view;
        $config['templates.path'] = $SL['LOCAL_APPS'] . '/templates';
        $app = new \Slim\Slim($config);
        //new \Services\SlimControllerMapper($app, $SL['APPPATH'] . '/config/routes');
        array_walk($SL['config']['app']['routes'], function($routes, $mapTo) use ($SL, $app) {
            $SL['routerFactory']($app, $mapTo, $routes);
        });
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
                    $controller->dispatch($action, $argv);
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
        return 'Hotel\\Controllers\\' . ucfirst($name);
    });
    $SL['controllerFactory'] = $SL->protect(function($name) use ($SL) {
        $className = $SL['getControllerClassName']($name);
        return new $className;
    });

    $SL['getEntityClassName'] = $SL->protect(function($name) {
        return 'Hotel\\Entities\\' . ucfirst($name);
    });

    $SL['acl'] = function($SL) {
        $acl = new Acl();
        $acl->addRole(new Role('customer'))
            ->addRole(new Role('operator'), 'customer')
            ->addRole(new Role('manager'), 'operator')
            ->addRole(new Role('superuser'), 'manager');
        $acl->addResource(new Resource('room'))
            ->addResource(new Resource('service'))
            ->addResource(new Resource('payment'))
            ->addResource(new Resource('report'))
            ->addResource(new Resource('user'));
        $acl->deny(null, null, null) // по-умолчанию запретить всё
            ->allow('customer', 'room', array('view', 'book', 'cancellation'))
            ->allow('customer', 'service', 'view')
            ->allow('operator', 'room', 'status')
            ->allow('operator', 'service', 'provide')
            ->allow('operator', 'payment', array('view', 'add'))
            ->allow('manager', 'room', array('add', 'remove', 'modify'))
            ->allow('manager', 'service', array('add', 'remove', 'modify'))
            ->allow('manager', 'report', 'view')
            ->allow('superuser', 'user', array('add', 'remove', 'modify'));
        return $acl;
    };

    return $SL;
});
