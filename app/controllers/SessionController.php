<?php

use Phalcon\Tag as Tag;

class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            Tag::setDefault('email', 'demo@codenode.lab');
            Tag::setDefault('password', 'codenode');
        }
    }

    public function registerAction()
    {
        $request = $this->request;
        if ($request->isPost()) {

            $name = $request->getPost('name', array('string', 'striptags'));
            $username = $request->getPost('username', 'alphanum');
            $email = $request->getPost('email', 'email');
            $password = $request->getPost('password');
            $repeatPassword = $this->request->getPost('repeatPassword');

            if ($password != $repeatPassword) {
                $this->flash->error('Passwords are different');
                return false;
            }

            $user = new Users();
            $user->username = $username;
            //CHANGE to bcrypt
            $user->password = sha1($password);
            $user->name = $name;
            $user->email = $email;
            $user->created_at = new Phalcon\Db\RawValue('now()');
            $user->active = 'Y';
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                Tag::setDefault('email', '');
                Tag::setDefault('password', '');
                $this->flash->success('Thanks for signing up, go ahead and log in to start coding');
                return $this->forward('session/index');
            }
        }
    }

    /**
     * Register authenticated user into session data
     *
     * @param Users $user
     */
     private function _registerSession($user)
     {
         $this->session->set('auth', array(
            'id' => $user->id,
            'name' => $user->name
            ));
         $userSettings = new \Phalcon\Session\Bag('userSettings');
         $userSettings->track = "algorithms";
         $userSettings->category = "warmup";
         $userSettings->lastChallenge = "none";
     }

     /**
      * This actions receive the input from the login form
      *
      */
     public function startAction()
     {
         if ($this->request->isPost()) {
             $email = $this->request->getPost('email', 'email');

             $password = $this->request->getPost('password');
             //CHANGE to bcrypt
             $password = sha1($password);

             $user = Users::findFirst("email='$email' AND password='$password' AND active='Y'");
             if ($user != false) {
                 $this->_registerSession($user);
                 $this->flash->success('Welcome ' . $user->name);
                 return $this->forward('challenges/index');
             }

             $username = $this->request->getPost('email', 'alphanum');
             $user = Users::findFirst("username='$username' AND password='$password' AND active='Y'");
             if ($user != false) {
                 $this->_registerSession($user);
                 $this->flash->success('Welcome ' . $user->name);
                 return $this->forward('challenges/index');
             }

             $this->flash->error('Wrong email/password');
         }

         return $this->forward('session/index');
     }

     /**
      * Finishes the active session redirecting to the index
      *
      * @return unknown
      */
     public function endAction()
     {
         $this->session->remove('auth');
         $this->flash->success('Goodbye!');
         return $this->forward('index/index');
     }
}
