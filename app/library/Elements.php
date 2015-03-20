<?php

/**
 * Elements
 *
 * Helps to build UI elements for the application
 */
class Elements extends Phalcon\Mvc\User\Component
{

    private $_headerMenu = array(
        'left' => array(
            'index' => array(
                'caption' => 'Home',
                'action' => 'index'
            ),
            'challenges' => array(
                'caption' => 'Challenges',
                'action' => 'index'
            ),
            'about' => array(
                'caption' => 'About',
                'action' => 'index',
            ),
            'contact' => array(
                'caption' => 'Contact',
                'action' => 'index'
            ),
        ),
        'right' => array(
            'account' => array(
                'caption' => 'My Profile',
                'action' => 'profile',
            ),
            'session' => array(
                'caption' => 'Log In/Sign Up',
                'action' => 'index'
            ),
        )
    );

    private $_tabs = array(
        'Tracks' => array(
            'controller' => 'tracks',
            'action' => 'index',
            'any' => false
        ),
        'Categories' => array(
            'controller' => 'categories',
            'action' => 'index',
            'any' => false
        ),
        'Challenges' => array(
            'controller' => 'challenges',
            'action' => 'index',
            'any' => false
        ),
    );

    /**
     * Builds header menu with left and right items
     *
     * @return string
     */
    public function getMenu()
    {
        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_headerMenu['right']['session'] = array(
                'caption' => 'Log Out',
                'action' => 'end'
            );
        } else {
            unset($this->_headerMenu['right']['account']);
            unset($this->_headerMenu['left']['challenges']);
        }

        echo '<div class="collapse navbar-collapse">';
        $controllerName = $this->view->getControllerName();
        foreach ($this->_headerMenu as $position => $menu) {
            echo '<ul class="nav navbar-nav navbar-', $position, '">';
            if($position == 'right' && $auth) {
                echo '<li class="dropdown">';
                echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">';
                echo '<i class="glyphicon glyphicon-user"></i>&nbsp;'.$auth['name'].'<span class="caret"></span></a>';
                echo '<ul id="g-account-menu" class="dropdown-menu" role="menu">';
            }
            foreach ($menu as $controller => $option) {
                if($position == 'right') {
                    echo '<li>';
                    echo Phalcon\Tag::linkTo($controller.'/'.$option['action'], $option['caption']);
                    echo "</li>\n";
                } else {
                    if ($controllerName == $controller) {
                        echo '<li class="active">';
                    } else {
                        echo '<li>';
                    }
                    echo Phalcon\Tag::linkTo($controller.'/'.$option['action'], $option['caption']);
                    echo "</li>\n";
                }
            }
            if($position == 'right' && $auth) {
                echo '</ul>';
                echo '</li>';
            } 
            echo '</ul>';
        }
        echo '</div><!--/navbar-collapse -->';
    }

    public function getTabs()
    {
        $controllerName = $this->view->getControllerName();
        $actionName = $this->view->getActionName();
        echo '<ul class="nav nav-tabs" role="tablist">';
        foreach ($this->_tabs as $caption => $option) {
            if ($option['controller'] == $controllerName && ($option['action'] == $actionName || $option['any'])) {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            echo Phalcon\Tag::linkTo($option['controller'].'/'.$option['action'], $caption), '<li>';
        }
        echo '</ul>';
    }
}
