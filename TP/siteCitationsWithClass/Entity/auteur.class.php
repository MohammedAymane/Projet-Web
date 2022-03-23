<?php
class Auteur
{
  private string $firstName = "";
  private string $lastName = "";

  public function __construct($firstName, $color)
  {
    $this->firstName = $firstName;
    $this->color = $color;
  }



  function setfirstName($firstName)
  {
    $this->firstName = $firstName;
  }
  function getfirstName(): string
  {
    return $this->firstName;
  }

  function setlastName($lastName)
  {
    $this->lastName = $lastName;
  }
  function getlastName(): string
  {
    return $this->lastName;
  }
  function __toString(): string
  {
    return $this->firstName . " " . $this->lastName;
  }
}


?>$this->lastName;
}

}


?>$this->lastName;
}

}


?>