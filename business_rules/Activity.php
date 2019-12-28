<?php

class Activity
{
    // activity attributes
    private $idActivity;
    private $name;
    private $desc;
    private $idAdmin;

    public function __construct($idActivity, $name, $desc, $idAdmin)
    {
        $this->idActivity = $idActivity;
        $this->name = $name;
        $this->desc = $desc;
        $this->idAdmin = $idAdmin;
    }

    /**
     * function to get the activity name
     *
     * @return mixed
     */
    public function activityName()
    {
        return $this->name;
    }

}