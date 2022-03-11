<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    /*
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
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']); //-03-01-2022-pao
        $builder->connect('/', ['controller' => 'Items', 'action' => 'dashboard']);
        $builder->connect('/', ['controller' => 'Users', 'action' => 'login']); //-03-01-2022-pao
        
        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display'); //-03-01-2022-pao
        // $builder->connect('/logreg/*', array('controller' => 'Users', 'action' => 'login')); //-03-01-2022-pao

 


        //User Routes
        $builder->connect('/add-user', ['controller' => 'Users', 'action' => 'addUser']); //-03-01-2022-pao
        $builder->connect('/edit-user/:id', ['controller' => 'Users', 'action' => 'editUser'], ['pass' => ['id']]); //-03-01-2022-pao
        $builder->connect('/delete-user/:id', ['controller' => 'Users', 'action' => 'deleteUser'], ['pass' => ['id']]); //-03-01-2022-pao
        $builder->connect('/list-users', ['controller' => 'Users', 'action' => 'listUsers']); //-03-01-2022-pao

        //Item Routes
        $builder->connect('/add-item', ['controller' => 'Items', 'action' => 'addItem']); //-03-01-2022-pao
        $builder->connect('/edit-item/:id', ['controller' => 'Items', 'action' => 'editItem'], ['pass' => ['id']]); //-03-01-2022-pao
        $builder->connect('/delete-item/:id', ['controller' => 'Items', 'action' => 'deleteItem'], ['pass' => ['id']]); //-03-01-2022-pao
        $builder->connect('/list-items', ['controller' => 'Items', 'action' => 'listItems']); //-03-01-2022-pao
        $builder->connect('/dashboard', ['controller' => 'Items', 'action' => 'dashboard']); //-03-01-2022-pao

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
