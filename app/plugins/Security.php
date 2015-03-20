<?php

use Phalcon\Events\Event,
        Phalcon\Mvc\User\Plugin,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Acl;

/**
 * Security
 *
 * This is the security plugin which ensures that users only have access to the modules they're assigned to
 */
 class Security extends Plugin
 {
     public function __construct($dependencyInjector)
     {
         $this->_dependencyInjector = $dependencyInjector;
     }

     public function getAcl()
     {
         if(!isset($this->persistent->acl)) {

             //Create the ACL
             $acl = new Phalcon\Acl\Adapter\Memory();

             //The default action is DENY access
             $acl->setDefaultAction(Phalcon\Acl::DENY);

             //Register roles
             $roles = array(
                        'admins' => new Phalcon\Acl\Role('Admins'),
                        'users' => new Phalcon\Acl\Role('Users'),
                        'guests' => new Phalcon\Acl\Role('Guests')
            );
            foreach ($roles as $role) {
                    $acl->addRole($role);
            }

            /**
             * Private area user resources (backend)
             */
            $privateUserResources = array(
                    'account' => array('index','profile'),
                    'tracks' => array('index','search','new','edit','create','save','delete'),
                    'categories' => array('index','search','new','edit','create','save','delete'),
                    'challenges' => array('index','view','search','new', 'edit', 'create', 'save', 'delete')
            );
            foreach ($privateUserResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }
            /**
             * Private area admin resources (backend)
             */
            $privateAdminResources = array(
                    'account' => array('index','profile'),
                    'admin' => array('index'),
                    'tracks' => array('index','search','new','edit','create','save','delete'),
                    'categories' => array('index','search','new','edit','create','save','delete'),
                    'challenges' => array('index','view','search','new', 'edit', 'create', 'save', 'delete')
            );
            foreach ($privateAdminResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Grant access to private area to role Users
            foreach ($privateUserResources as $resource => $actions) {
                    foreach ($actions as $action) {
                            $acl->allow('Users', $resource, $action);
                    }
            }
            //Grant access to private area to role Users
            foreach ($privateAdminResources as $resource => $actions) {
                    foreach ($actions as $action) {
                            $acl->allow('Admins', $resource, $action);
                    }
            }

            /**
             * Public area resources (frontend)
             */
            $publicResources = array(
                    'index' => array('index'),
                    'about' => array('index'),
                    'session' => array('index', 'register', 'start', 'end'),
                    'contact' => array('index', 'send')
            );
            foreach ($publicResources as $resource => $actions) {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {
                    foreach ($publicResources as $resource => $actions) {
                            $acl->allow($role->getName(), $resource, '*');
                    }
            }
            /**End Public area resources**/

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
         }

         return $this->persistent->acl;
     }

     /**
      * This action is executed before execute any action in the application
      */
     public function beforeDispatch(Event $event, Dispatcher $dispatcher)
     {
         
         $auth = $this->session->get('auth');
         if (!$auth){
             $role = 'Guests';
         } else {
             $role = 'Users';
         }

         $controller = $dispatcher->getControllerName();
         $action = $dispatcher->getActionName();

         $acl = $this->getAcl();

         $allowed = $acl->isAllowed($role, $controller, $action);
         if ($allowed != Acl::ALLOW) {
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                        array(
                                'controller' => 'index',
                                'action' => 'index'
                        )
                );
                return false;
         }
     }
 }
