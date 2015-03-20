<?php

class ChallengeData extends Phalcon\Mvc\Model
{
    protected $id;

    protected $challenge_id;

    protected $problem;

    public function getId()
    {
        return $this->id;
    }

    public function getChallengeId()
    {
        return $this->challenge_id;
    }

    public function setProblem($problem)
    {
        if (strlen($problem) > 16777215) {
            throw new \InvalidArgumentException('The problem set is too large.');
        }
    }

    public function getProblem()
    {
        return $this->problem;
    }

    public function initialize()
    {

    }

}
