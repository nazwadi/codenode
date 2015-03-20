<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Phalcon\Tag::setTitle('Welcome');
        parent::initialize();
    }
    public function indexAction()
    {
        if(!$this->request->isPost()) {
            $this->flash->notice('This is a prototype for the Codenode application.
                Please excuse the mess.  Thanks. - Nazwadi');
        }
    }

}
