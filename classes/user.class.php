<?php
//create a class user with attributes firstname, lastname, email, password, role, service
class User
{
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $role;
    private $service;
    private $phone;

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


    public function getPhone()
    {
        return $this->phone;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

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