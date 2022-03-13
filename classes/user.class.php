<?php
//create a class user with attributes firstname, lastname, email, password, role, service
class User
{
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $role;
    private $service;

    public function __construct($firstname, $lastname, $email, $password, $role, $service)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->service = $service;
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
}