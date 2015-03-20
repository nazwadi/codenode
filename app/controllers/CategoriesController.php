<?php

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;

class CategoriesController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('Manage your Challenge Categories');
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
            $query = Criteria::fromInput($this->di, "ChallengeCategories", $_POST);
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

        $categories = ChallengeCategories::find($parameters);
        if (count($categories) == 0) {
            $this->flash->notice("The search did not find any matching categories");
            return $this->forward("categories/index");
        }

        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            "data" => $categories,
            "limit" => 5,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
        $this->view->setVar("categories", $categories);
    }

    public function newAction()
    {
        $this->view->setVar("tracks", Tracks::find());
    }

    public function editAction($id)
    {
        $request = $this->request;
        if (!$request->isPost()) {

            $id = $this->filter->sanitize($id, array("int"));

            $categories = ChallengeCategories::findFirst(array('id=:id:','bind' => array('id' => $id)));
            if (!$categories) {
                $this->flash->error("Category to edit was not found");
                return $this->forward("categories/index");
            }

            $this->view->setVar("id", $categories->id);
            $this->view->setVar("tracks", Tracks::find());

            Tag::displayTo("id", $categories->id);
            Tag::displayTo("track", $categories->track_id);
            Tag::displayTo("name", $categories->name);
        }
    }

    public function createAction()
    {

        $request = $this->request;

        if (!$request->isPost()) {
            return $this->forward("categories/index");
        }

        $categories = new ChallengeCategories();
        $categories->id = $request->getPost("id", "int");
        $categories->track_id = $request->getPost("track", "int");
        $categories->name = $request->getPost("name");

        $categories->name = strip_tags($categories->name);
        $categories->uri_name = str_replace(" ","-",$categories->name);
        $categories->uri_name = strtolower($categories->uri_name);

        if (!$categories->save()) {

            foreach ($categories->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("categories/new");

        } else {
            $this->flash->success("Category was created successfully");
            return $this->forward("categories/index");
        }
    }

    public function saveAction()
    {
        $request = $this->request;

        if (!$request->isPost()) {
            return $this->forward("categories/index");
        }

        $id = $request->getPost("id", "int");
        $categories = ChallengeCategories::findFirst("id='$id'");
        if ($categories == false) {
            $this->flash->error("Category does not exist ".$id);

            return $this->forward("categories/index");
        }

        $categories->id = $request->getPost("id", "int");
        $categories->track_id = $request->getPost("track", "int");
        $categories->name = $request->getPost("name", "striptags");
        $categories->uri_name = $request->getPost("name","striptags");

        if (!$categories->save()) {
            foreach ($categories->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return $this->forward("categories/edit/" . $categories->id);
        } else {
            $this->flash->success("Category was successfully updated");
            return $this->forward("categories/index");
        }
    }

    public function deleteAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $categories = ChallengeCategories::findFirst('id="' . $id . '"');
        if (!$categories) {
            $this->flash->error("Category was not found");

            return $this->forward("categories/index");
        }

        if (!$categories->delete()) {
            foreach ($categories->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("categories/search");
        } else {
            $this->flash->success("Category was deleted");
            return $this->forward("categories/index");
        }
    }
}
