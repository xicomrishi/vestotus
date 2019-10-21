<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRouted;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);
    $routes->connect('/contact/', ['controller' => 'Pages', 'action' => 'contact']);
    $routes->connect('/admin/', ['controller' => 'Users', 'action' => 'login','prefix'=>'admin']);
    $routes->connect('/admin', ['controller' => 'Users', 'action' => 'login','prefix'=>'admin']);
    $routes->connect('/admin/login', ['controller' => 'Users', 'action' => 'login','prefix'=>'admin']);
    $routes->connect('/empower', ['controller' => 'Pages', 'action' => 'view','empower','prefix'=>false]);
    $routes->connect('/about', ['controller' => 'Pages', 'action' => 'view','about','prefix'=>false]);
    $routes->connect('/faq-safely-training', ['controller' => 'Pages', 'action' => 'view','faq-safely-training','prefix'=>false]);
    $routes->connect('/about-courses', ['controller' => 'Pages', 'action' => 'view','about-courses','prefix'=>false]);
    $routes->connect('/faqs', ['controller' => 'Pages', 'action' => 'faqs','prefix'=>false]);
    $routes->connect('/facts-about-training', ['controller' => 'Pages', 'action' => 'view','facts-about-training','prefix'=>false]);
    $routes->connect('/share', ['controller' => 'Pages', 'action' => 'view','share','prefix'=>false]);
    $routes->connect('/build', ['controller' => 'Pages', 'action' => 'view','build','prefix'=>false]);
    $routes->connect('/para-transit', ['controller' => 'Pages', 'action' => 'view','para-transit','prefix'=>false]);
    $routes->connect('/towing', ['controller' => 'Pages', 'action' => 'view','towing','prefix'=>false]);
    $routes->connect('/commercial-fleet', ['controller' => 'Pages', 'action' => 'view','commercial-fleet','prefix'=>false]);
    $routes->connect('/municipalities', ['controller' => 'Pages', 'action' => 'view','municipalities','prefix'=>false]);
    $routes->connect('/custom-services', ['controller' => 'Pages', 'action' => 'view','custom-services','prefix'=>false]);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    Router::prefix('Admin', ['_namePrefix' => 'admin:'], function ($routes) {
    // Connect routes.
});

    $routes->fallbacks('DashedRoute');
      Router::prefix('Admin', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
