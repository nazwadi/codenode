<?php

class Tracks extends Phalcon\Mvc\Model
{
    /**
     * @var integer
     */
    public $id;

    
    /**
     * @var string
     */
    public $name;

    public function initialize()
    {
        // This model, Tracks, has many ChallengeCategories
        // where the local id field maps to the ChallengeCategories model's track_id
        $this->hasMany("id", "ChallengeCategories", "track_id");
    }
}
