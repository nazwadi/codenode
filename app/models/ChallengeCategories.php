<?php

class ChallengeCategories extends Phalcon\Mvc\Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $track_id;

    /**
     * @var string
     */
    public $name;

    public function initialize()
    {
        // This model, ChallengeCategories, has a many-to-one relationship with Tracks
        // where the local "track_id" field maps to the Tracks model's "id" field
        $this->belongsTo("track_id", "Tracks", "id");

    }

}
