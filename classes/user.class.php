<?php
//create a class user with attributes firstname, lastname, email, password, role, service
class User
{
    //attributs
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $role;
    private $service;
    private $phone;

    //constructeur
    public function __construct($firstname, $lastname, $email, $password, $role, $service, $phone, $id = null)
    {
        if ($id == null) $this->id = uniqid("user-", true);
        else $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->service = $service;
        $this->phone = $phone;
    }

    //méthodes

    /**
     * Get the value of the phone number
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the value of the first name
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of last name
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of service
     */
    public function getService()
    {
        return $this->service;
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