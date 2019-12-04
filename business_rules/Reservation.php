<?php

class Reservation
{
    // reservation attributes
    private $idUser;
    private $idActivity;
    private $reservationDate;
    private $state;

    public function __construct($idUser, $idActivity, $reservationDate, $state)
    {
        $this->idUser = $idUser;
        $this->idActivity = $idActivity;
        $this->reservationDate = $reservationDate;
        $this->state = $state;
    }

    /**
     * function to get the reservation date
     *
     * @return mixed
     */
    public function reservationDate()
    {
        return $this->reservationDate;
    }
}
