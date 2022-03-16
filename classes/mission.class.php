<?php

class Mission {
    private string $lieu;
    private $debut;
    private $fin;
    private string $devise;
    private string $description;
    private string $etat;
    private float $solde_initial;
    private int $user_id;

    public function __construct($lieu,$debut,$fin,$devise,$description,$etat,$solde_initial,$user_id){
        $this->lieu = $lieu;
        $this->debut = $debut;
        $this->fin = $fin;
        $this->devise = $devise;
        $this->description = $description;
        $this->etat = $etat;
        $this->solde_initial = $solde_initial;
        $this->user_id = $user_id;
    }




    /**
     * Get the value of lieu
     */ 
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Get the value of debut
     */ 
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Get the value of fin
     */ 
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Get the value of devise
     */ 
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of etat
     */ 
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Get the value of solde_initial
     */ 
    public function getSolde_initial()
    {
        return $this->solde_initial;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }
}
?>