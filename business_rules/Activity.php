<?php

class Activity
{
    // activity attributes
    private $idActivity;
    private $name;
    private $desc;
    private $idAdmin;
    private $idImage;

    public function __construct($idActivity, $name, $desc, $idAdmin, $idImage)
    {
        $this->idActivity = $idActivity;
        $this->name = $name;
        $this->desc = $desc;
        $this->idAdmin = $idAdmin;
        $this->idImage = $idImage;
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