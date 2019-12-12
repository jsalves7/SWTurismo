<?php

class Reservation
{
    // reservation attributes
    private $idUser;
    private $idActivity;
    private $reservationDate;
    private $state;
    private $idCreditCard;

    public function __construct($idUser, $idActivity, $reservationDate, $state, $idCreditCard)
    {
        $this->idUser = $idUser;
        $this->idActivity = $idActivity;
        $this->reservationDate = $reservationDate;
        $this->state = $state;
        $this->idCreditCard = $idCreditCard;
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
