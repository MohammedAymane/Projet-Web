<?php

class Operation {
    private $date;
    private $description;
    private $montant;
    private $id_nomenclature;
    private $id_mission;

    public function __construct($date,$description,$montant,$id_nomenclature,$id_mission) {
        $this->date = $date;
        $this->description = $description;
        $this->montant = $montant;
        $this->id_nomenclature = $id_nomenclature;
        $this->id_mission = $id_mission;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of solde_initial
     */ 
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Get the value of user_id
     */ 
    public function getID_nomenclature()
    {
        return $this->id_nomenclature;
    }

    /**
     * Get the value of user_id
     */ 
    public function getID_mission()
    {
        return $this->id_mission;
    }
}
?>