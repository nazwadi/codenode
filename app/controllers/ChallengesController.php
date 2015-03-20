<?php

use Phalcon\Tag as Tag;
use Phalcon\Flash as Flash;
use Phalcon\Session as Session;

class ChallengesController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('View Programming Challenges');
        $tracks = Tracks::find();
        $this->view->setVar("tracks", $tracks);

        // Build sidebar categories organized by track
        $categories = array();
        $conditions = "track_id = :track_id:";
        foreach($tracks as $track) {
            $parameters = array(
                "track_id" => $track->id
            );
            $rows = ChallengeCategories::find(array(
                $conditions,
                "bind" => $parameters
            ));
            $categories[$track->id] = $rows;
        }
        $this->view->setVar("categories", $categories);

        parent::initialize();
    }

    public function indexAction($trackUriName = '',$categoryUriName='')
    {
        $userSettings = new \Phalcon\Session\Bag('userSettings');
        if(empty($trackUriName)) {
            $trackUriName = $userSettings->track;
        }
        if(empty($categoryUriName)) {
            $categoryUriName = $userSettings->category;
        }
        $filter = new \Phalcon\Filter();

        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");
        if ($numberPage <= 0) {
            $numberPage = 1;
        }
        
        $trackUriName = $filter->sanitize($trackUriName,"string");
        $categoryUriName = $filter->sanitize($categoryUriName,"string");

        /**
         * Query for the Track id that matches the trackName provided in the url
         * Binded queries protect against SQL injection attacks
         */
         $conditions = "uri_name = :uri_name:";
         $parameters = array(
            "uri_name" => $trackUriName
        );
         $row = Tracks::FindFirst(array(
            $conditions,
            "bind" => $parameters
        ));
        if (count($row) == 0 || $row == false) {
            $this->flash->notice("The track you are looking for does not exist.");
        } else {
            $track = $row;
        }

        if(isset($track)) {
            /**
             * Query for the ChallengeCategory id that matches the name provided in the url
             * Binded queries protect against SQL injection attacks
             */
            $conditions = "track_id = :track_id: AND uri_name = :uri_name:";
            $parameters = array(
                "track_id" => $track->id,
                "uri_name" => $categoryUriName
            );
            $row = ChallengeCategories::FindFirst(array(
                $conditions,
                "bind" => $parameters
            ));
            if (count($row) == 0 || $row == false) {
                $this->flash->notice("There are no challenges currently available for this category.");
            } else {
                $category = $row;
            }
        }

        if(isset($category)) {
            /**
             * Query for the Challenges that match the given category
             * Binded queries protect against SQL injection attacks
             */
            // Query challenges binding parameters with string placeholders
            $conditions = "challenge_category_id = :challenge_category_id:";

            // Parameters whose keys are the same as placeholders
            $parameters = array(
                "challenge_category_id" => "$category->id"
            );

            //Perform the query
            $challenges = Challenges::find(array(
                $conditions,
                "bind" => $parameters
            )); 
            if (count($challenges) == 0) {
                $this->flash->notice("There are no challenges currently available for this category.");
            }
        } else {
            // When the result set is empty,
            // we build an empty data object for the paginator
            $challenges = new stdClass();
            $challenges->items=array();
            $challenges->total_pages=0;
            $challenges->total_items=0;
        }

        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            "data" => $challenges,
            "limit" => 10,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("current_track",$track);
        $this->view->setVar("current_category", $category);
        $this->view->setVar("page", $page);
        $this->view->setVar("challenges", $challenges);
    }

    public function viewAction($uriName)
    {
        $filter = new \Phalcon\Filter();
        $uriName = $filter->sanitize($uriName,"string");

        // Query the challenges table for a matching uri_name
        $conditions = 'uri_name = :uri_name:';
        $parameters = array(
            'uri_name' => $uriName
        );
        $challenge = Challenges::findFirst(array(
            $conditions,
            "bind" => $parameters
        ));

        // Query the challenge_data table for a matching challenge_id
        $conditions = 'challenge_id = :challenge_id:';
        $parameters = array(
            'challenge_id' => $challenge->id
        );
        $ch_data = ChallengeData::findFirst(array(
            $conditions,
            "bind" => $parameters
        ));
        $this->view->setVar("challenge", $challenge);
        $this->view->setVar("data",$ch_data);
    }

    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Challenges", $_POST);
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

        $challenges = Challenges::find($parameters);
        if (count($challenges) == 0) {
            $this->flash->notice("The search did not find any matching challenges.");
            return $this->forward("challenges/index");
        }

        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            "data" => $challenges,
            "limit" => 10,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
        $this->view->setVar("challenges", $challenges);
    }

    public function newAction()
    {
        $this->view->setVar("challengeCategories", ChallengeCategories::find());
        $this->view->setVar("difficultyLevels", DifficultyLevels::find());
    }

    public function editAction($id)
    {
        $request = $this->request;
        $this->view->setVar("challengeCategories", ChallengeCategories::find());
        if (!$request->isPost()) {

            $challenge = Challenges::findFirst(array('id=:id:', 'bind' => array('id' => $id)));
            $challengeData = ChallengeData::findFirst(array(
                'challenge_id=:challenge_id:', 
                'bind' => array('challenge_id' => $id))
            );
            if (!$challenge) {
                $this->flash->error("Challenge to edit was not found.");
                return $this->forward("challenges/index");
            }
            $this->view->setVar("id", $challenge->id);
            $this->view->setVar("difficultyLevels", DifficultyLevels::find());

            Tag::displayTo("id", $challenge->id);
            Tag::displayTo("category", $challenge->challenge_category_id);
            Tag::displayTo("name", $challenge->name);
            Tag::displayTo("description", $challenge->description);
            Tag::displayTo("difficulty", $challenge->difficulty);
            Tag::displayTo("points", $challenge->point_value);
            Tag::displayTo("problem", $challengeData->getProblem());
        }
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("challenges/index");
        }

        $challenge = new Challenges();
        $challengeData = new ChallengeData();
        $request = $this->request;

        // Grab challenge meta-data from user input
        $challenge->id = $request->getPost("id", "int");
        // Might need to fix the translation from challenge_category_id to category in form
        $challenge->challenge_category_id = $request->getPost("category","int");
        $challenge->name = $request->getPost("name");
        $challenge->description = $request->getPost("description");
        $challenge->difficulty = $request->getPost("difficulty");
        $challenge->point_value = $request->getPost("points","int");
        
        // Manipulate input
        $challenge->name = strip_tags($challenge->name);
        $challenge->uri_name = strtolower($challenge->name);
        $challenge->uri_name = str_replace(" ","-",$challenge->uri_name);
        $challenge->description = strip_tags($challenge->description);
        $challenge->difficulty = strip_tags($challenge->difficulty);

        // Grab challenge data (the problem set itself) from user input
        // $challengeData->challenge_id will be set after the challenge is saved
        // so that the id can be retrieved
        $challengeData->problem = $request->getPost("problem");

        // Phalcon\Mvc\Model::save()
        if (!$challenge->save()) {
            foreach ($challenge->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("challenges/new");
        } else { // Challenge saved successfully
            $challenge = Challenges::findFirst(array('name=:name:', 'bind' => array('name' => $challenge->name)));
            $challengeData->challenge_id = $challenge->id;
            // Save the Data associated with this challenge
            if (!$challengeData->save()) {
                foreach ($challengeData->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
                return $this->forward("challenges/new");
            }
            $this->flash->success("Challenge was created successfully");
            return $this->forward("challenges/index");
        }

    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->forward("challenges/index");
        }

        $id = $this->request->getPost("id", "int");
        $challenge = Challenges::findFirst("id='$id'");
        $challengeData = ChallengeData::findFirst("challenge_id='$id'");
        $request = $this->request;

        if ($challenge == false) {
            $this->flash->error("Challenge does not exist " . $id);

            return $this->forward("challenges/index");
        }

        $challenge->challenge_category_id = $request->getPost("category", "int");
        $challenge->name = $request->getPost("name", "striptags");
        $challenge->uri_name = strtolower($challenge->name);
        $challenge->uri_name = str_replace(" ","-",$challenge->uri_name);
        $challenge->description = $request->getPost("description", "striptags");
        $challenge->difficulty = $request->getPost("difficulty", "striptags");
        $challenge->point_value = $request->getPost("points", "int");

        // Grab challenge data (the problem set itself) from user input
        $challengeData->challenge_id = $id;
        $challengeData->problem = $request->getPost("problem");

        if (!$challenge->save()) {
            foreach ($challenge->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("challenges/edit/" . $challenge->id);
        } else {
            // Save the Data associated with this challenge
            if (!$challengeData->save()) {
                foreach ($challengeData->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
                return $this->forward("challenges/edit" . $challenge->id);
            }
            $this->flash->success("Challenge ".htmlentities($challenge->name)." was updated successfully!");
            return $this->forward("challenges/index");
        }
    }

    public function deleteAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $challenge = Challenges::findFirst('id="' . $id . '"');
        if (!$challenge) {
            $this->flash->error("Challenge was not found.");

            return $this->forward("challenges/index");
        }

        if (!$challenge->delete()) {
            foreach ($challenge->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("challenges/search");
        } else {
            if (!$challengeData->delete()) {
                foreach ($challengeData->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
                return $this->forward("challenges/search" . $challenge->id);
            }
            $this->flash->success("Challenge was deleted.");
            return $this->forward("challenges/index");
        }
    }
}
