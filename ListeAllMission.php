<!DOCTYPE html >
<html lang="fr">
 <head>
 <title>afficher tous les missions </title>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
 </head>

 <body>
   <?php
   include "navbar.php";
   include "services/dbFunctions.php";
   redirectOut();
   $user_id = $_SESSION["id"];
   ?>

   <div class="container-fluid p-4 bg-success text-white text-center bg-opacity-50">
     <h2>Vue Globale</h2>
   </div>

   <form class="container p-3" method="post" action="ListeAllMission.php">
     <div class="row">
     <p class="h5 col-2">Filtres : </p>
     <div class="col-2">
     <input class="form-control" list="employeOptions" id="employe" name="employe" placeholder="Employé">
      <datalist id="employeOptions">
        <?php
        $result = getUsers();
        $listeName = $result["result"];
        foreach ($listeName as $name) {
          ?>
            <option value="<?php echo $name['firstName']." ".$name['lastName'] ?>"/>
          <?php }
           ?>
      </datalist>
    </div>
    <div class="col-2">
      <input class="form-control" list="statutOptions" id="statut" name="statut" placeholder="Statut">
       <datalist id="statutOptions">
         <option value="en Cours">
         <option value="finis">
         <option value="annulee">
         <option value="supprimee">
       </datalist>
   </div>
   <div class="col-2">
     <input class="btn btn-outline-success bg-opacity-50" type="submit" name="afficher" value="afficher"/>
   </div>
 </div>
</form>


  <div class="container p-3">
   <!-- Tableau contenant les citations sauvegardees dans la base de donnees -->
   <table class="table table-striped">
     <thead>
       <tr>
         <th>Employé</th>
         <th>Lieu</th>
         <th>Date</th>
         <th>Statut</th>
         <th>Solde initial</th>
       </tr>
     </thead>
     <tbody>
       <?php
       $sqlexp = "";
       if($_SERVER["REQUEST_METHOD"] == "POST"){
         $employeSelect = $_POST['employe'];
         $statutSelect = $_POST['statut'];
         if(empty($_POST['statut'])){
           $arr = explode(" ", $employeSelect);
           $firstNameSelect = $arr[0];
           $lastNameSelect = $arr[1];
           $sqlexp = " WHERE instr(firstName,'$firstNameSelect')>0"." AND instr(lastName,'$lastNameSelect')>0";
         }else if(empty($_POST['employe'])){

           $sqlexp = " WHERE instr(etat,'$statutSelect')>0";
         }else{
           $arr = explode(" ", $employeSelect);
           $firstNameSelect = $arr[0];
           $lastNameSelect = $arr[1];
           $sqlexp = " WHERE instr(firstName,'$firstNameSelect')>0"." AND instr(lastName,'$lastNameSelect')>0"." AND instr(etat,'$statutSelect')>0";
         }

       }


       $result = getMissionsByWhere($sqlexp);
       $listeMissions = $result["result"];

       foreach ($listeMissions as $mission) {
         ?>
         <tr>
           <td><?php echo $mission["firstName"]." ".$mission["lastName"] ?></td>
           <td><?php echo $mission['lieu'] ?></td>
           <td><?php echo $mission['debut']." - ".$mission['fin'] ?></td>
           <td><?php echo $mission['etat'] ?></td>
           <td><?php echo $mission['solde_initial']." ".$mission['devise'] ?></td>
         </tr>
         <?php }
          ?>


        </tbody>
      </table>
    </div>
    </body>
</html>
