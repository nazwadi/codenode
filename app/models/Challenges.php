<?php

class Challenges extends Phalcon\Mvc\Model
{
    /**
     * @var integer
    */
    public $id;

    /**
     * @var integer
     */
    public $challenge_category_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var integer
     */
    public $submissions;

    /**
     * @var string
     */
    public $difficulty;

    /**
     * @var integer
     */
    public $point_value;

    public function initialize()
    {
        $this->belongsTo('challenge_category_id', 'ChallengeCategories', 'id', array(
            'reusable' => true
        ));
    }

}
    
