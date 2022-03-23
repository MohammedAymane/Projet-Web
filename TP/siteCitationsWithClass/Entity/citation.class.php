<?php

include_once "auteur.class.php"; //import class file
class Citation
{
    private Auteur $auteur;
    private string $date = "";
    private string $content = "";

    public function __construct(Auteur $auteur, $date, $content)
    {
        $this->auteur = $auteur;
        $this->date = $date;
        $this->content = $content;
    }

    function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }
    function getAuteur(): Auteur
    {
        return $this->auteur;
    }

    function setcontent($content)
    {
        $this->content = $content;
    }
    function getcontent(): string
    {
        return $this->content;
    }

    function setDate($date)
    {
        $this->date = $date;
    }
    function getDate(): string
    {
        return $this->date;
    }
}

?>
