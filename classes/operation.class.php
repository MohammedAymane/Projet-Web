<?php
// SOULIÉ Hortense
class Operation
{
    // attributs
    private $id;
    private $date;
    private $description;
    private $montant;
    private $id_nomenclature;
    private $id_mission;

    //constructeur
    public function __construct($date, $description, $montant, $id_nomenclature, $id_mission, $id = null)
    {
        if ($id == null) $this->id = uniqid("op-", true);
        else $this->id = $id;
        $this->date = $date;
        $this->description = $description;
        $this->montant = $montant;
        $this->id_nomenclature = $id_nomenclature;
        $this->id_mission = $id_mission;
    }

    // methods

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
     * Get the value of montant
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Get the value of id_nomenclature
     */
    public function getID_nomenclature()
    {
        return $this->id_nomenclature;
    }

    /**
     * Get the value of mission_id
     */
    public function getID_mission()
    {
        return $this->id_mission;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}