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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/admin', array('controller' => 'admins', 'action' => 'login', 'prefix' => 'admin'));
/*	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));*/
/*Router::connect('/admin', array('controller' => 'admins', 'action' => 'login', 'admin'));*/
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect('/', array('controller' => 'home', 'action' => 'index'));
Router::connect('/equipment-for-sale/:p1/:p2', array('controller' => 'Equipments', 'action' => 'index') ,array(
            'p1','p2'));
Router::connect('/equipment-for-sale/:p1', array('controller' => 'Equipments', 'action' => 'view'),array(
            'p1'),array('persist' => array('p1')));

Router::connect('/equipment-for-sale', array('controller' => 'Equipments', 'action' => 'view'));
Router::connect('/chiropractic', array('controller' => 'home', 'action' => 'chiropractic'));
Router::connect('/psychotherapy', array('controller' => 'home', 'action' => 'psychotherapy'));
Router::connect('/veterinary', array('controller' => 'home', 'action' => 'veterinary'));
Router::connect('/medical', array('controller' => 'home', 'action' => 'medical'));
Router::connect('/dental', array('controller' => 'home', 'action' => 'dental'));
Router::connect('/error404', array('controller' => 'pages', 'action' => 'error404'));
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/office-space-wanted/*', array('controller' => 'listing', 'action' => 'classified_listing'));
Router::connect('/listing/adds', array('controller' => 'listing', 'action' => 'adds'));
Router::connect('/about-us', array('controller' => 'cms', 'action' => 'about_us'));
Router::connect('/contact-us', array('controller' => 'cms', 'action' => 'contact_us'));
Router::connect('/our-listings', array('controller' => 'cms', 'action' => 'our_listings'));
Router::connect('/press-release', array('controller' => 'cms', 'action' => 'press_release'));
Router::connect('/therapy-office-space-rent', array('controller' => 'cms', 'action' => 'therapy_office_space_rent'));
Router::connect('/chiropractic-practices-sale', array('controller' => 'cms', 'action' => 'chiropractic_practices_sale'));
Router::connect('/dental-practices-sale', array('controller' => 'cms', 'action' => 'dental_practices_sale'));
Router::connect('/medical-office-space-lease', array('controller' => 'cms', 'action' => 'medical_office_space_lease'));
//Router::connect('/blog', array('controller' => 'cms', 'action' => 'blog'));
Router::connect('/terms-of-services', array('controller' => 'cms', 'action' => 'terms'));
Router::connect('/privacy-policy', array('controller' => 'cms', 'action' => 'privacy'));
Router::connect('/dhs-providers', array('controller' => 'cms', 'action' => 'dhs'));
Router::connect('/partners', array('controller' => 'cms', 'action' => 'partners'));
Router::connect('/help', array('controller' => 'cms', 'action' => 'faq'));
Router::connect('/sign-up', array('controller' => 'home', 'action' => 'landing_page1'));
Router::connect('/blogsignup', array('controller' => 'home', 'action' => 'blogsignup'));
Router::connect('/form', array('controller' => 'home', 'action' => 'landing_page2'));
Router::connect('admin/our-listing', array('controller' => 'cms', 'action' => 'ourlistings','prefix' => 'admin'));
Router::connect('/listings/:p1/:p2/:p3', 
        array('controller' => 'listing', 'action' => 'userlisting_detail'), 
        array(
            'p1', // regex to match correct tokens
            'p2', // regex again to ensure a valid slug or 404
            'p3',
            

        ));
Router::connect('/classifieds/:p1', 
        array('controller' => 'listing', 'action' => 'classified_listdetail'), 
        array(
            'p1', // regex to match correct tokens
           

        ));

Router::connect('/form/:p1', 
        array('controller' => 'home', 'action' => 'landing_page2'), 
        array(
            'p1', // regex to match correct tokens
           

        ));


// City Pages 

Router::connect('/listings/new-york-city', array('controller' => 'listing', 'action' => 'index','new-york-city'),array('p1'=>'new-york-city'));
Router::connect('/listings/boston', array('controller' => 'listing', 'action' => 'index','massachusetts'));
Router::connect('/listings/philadelphia', array('controller' => 'listing', 'action' => 'index','pennsylvania'));
Router::connect('/listings/san-francisco', array('controller' => 'listing', 'action' => 'index','california'));
Router::connect('/listings/chicago', array('controller' => 'listing', 'action' => 'index','illinois'));
Router::connect('/listings/miami', array('controller' => 'listing', 'action' => 'index','florida'));
Router::connect('/listings/florida', array('controller' => 'listing', 'action' => 'index','miami'));
Router::connect('/form2/*', array('controller' => 'equipments', 'action' => 'form'));
Router::connect('/signup2/*', array('controller' => 'equipments', 'action' => 'signup'));
Router::connect('/medical-equipment-for-sale', array('controller' => 'equipments', 'action' => 'medical_equipment'));
Router::connect('/tips-avoid-scams', array('controller' => 'home', 'action' => 'tips_avoid_scams'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
Router::redirect('/home/landing_page1','/sign-up');
Router::redirect('/signup','/sign-up');
Router::redirect('http://clineedsbeta.com/?','http://clineedsbeta.com/');
Router::redirect('/listing/classified-listing','/office-space-wanted');
Router::redirect('/equipments/medical_equipment','/medical-equipment-for-sale');
Router::redirect('/home/tips_avoid_scams','/tips-avoid-scams');


CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
