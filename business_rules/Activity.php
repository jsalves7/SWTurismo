<?php

class Activity
{
    // activity attributes
    private $idActivity;
    private $name;
    private $desc;
    private $price;
    private $idAdmin;
    private $idImage;

    public function __construct($idActivity, $name, $desc, $price, $idAdmin, $idImage)
    {
        $this->idActivity = $idActivity;
        $this->name = $name;
        $this->desc = $desc;
        $this->price = $price;
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

    /**
     * function to get the activity price
     *
     * @return mixed
     */
    public function activityPrice()
    {
        return $this->price;
    }
}