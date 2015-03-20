<?php

use Phalcon\Tag as Tag;
use Phalcon\Mvc\Model\Criteria;

class TracksController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('View Tracks');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Tracks", $_POST);
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            if ($numberPage <= 0) {
                $numberPage = 1;
            }
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $tracks = Tracks::find($parameters);
        if (count($tracks) == 0) {
            $this->flash->notice("The search did not find any tracks.");
            return $this->forward("tracks/index");
        }

        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            "data" => $tracks,
            "limit" => 10,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
        $this->view->setVar("tracks", $tracks);
    }

    public function newAction()
    {
    }

    public function editAction($id)
    {
        $request = $this->request;
        if (!$request->isPost()) {

            $tracks = Tracks::findFirst(array('id=:id:', 'bind' => array('id' => $id)));
            if (!$tracks) {
                $this->flash->error("Track to edit was not found");
                return $this->forward("tracks/index");
            }
            $this->view->setVar("id", $tracks->id);

            Tag::displayTo("id", $tracks->id);
            Tag::displayTo("name", $tracks->name);
        }
    }

    public function createAction()
    {
        if(!$this->request->isPost()) {
            return $this->forward("tracks/index");
        }

        $tracks = new Tracks();
        $tracks->id = $this->request->getPost("id", "int");
        $tracks->name = $this->request->getPost("name");

        $tracks->name = strip_tags($tracks->name);
        $tracks->uri_name = str_replace(" ","-",$tracks->name);
        $tracks->uri_name = strtolower($tracks->uri_name);

        if(!$tracks->save()) {
            foreach ($tracks->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("tracks/new");
        } else {
            $this->flash->success("Track was created successfully");
            return $this->forward("tracks/index");
        }
    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("tracks/index");
        }

        $id = $this->request->getPost("id", "int");
        $tracks = Tracks::findFirst("id='$id'");
        if ($tracks == false) {
            $this->flash->error("Track does not exist " . $id);

            return $this->forward("tracks/index");
        }
        $tracks->id = $this->request->getPost("id", "int");
        $tracks->name = $this->request->getPost("name", "striptags");
        $tracks->uri_name = $request->getPost("name","striptags");

        if (!$tracks->save()) {
            foreach ($tracks->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("tracks/edit/" . $tracks->id);
        } else {
            $this->flash->success("Track was updated successfully");
            return $this->forward("tracks/index");
        }
    }

    public function deleteAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $tracks = Tracks::findFirst('id="' . $id . '"');
        if (!$tracks) {
            $this->flash->error("Track was not found.");

            return $this->forward("tracks/index");
        }

        if (!$tracks->delete()) {
            foreach ($tracks->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("tracks/search");
        } else {
            $this->flash->success("Track was deleted successfully.");
            return $this->forward("tracks/index");
        }
    }
}
