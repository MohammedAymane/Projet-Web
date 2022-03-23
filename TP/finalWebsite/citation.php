
<?php
session_start();
if ($_SESSION["loggedIn"]) {
    include "navbar.php";
}
?>


<table style="background-color: #00bfff;" cellspacing="0" cellpadding="0" border="1" id="yui_3_17_2_1_1646206705573_67">


<tbody id="yui_3_17_2_1_1646206705573_66">
    <tr>
        <td width="103" valign="top">
            <p align="center"><b>Login</b></p>
        </td>
        <td width="123" valign="top">
            <p style="text-align: center;" align="center"><b>Auteur</b></p>
        </td>
        <td width="146" valign="top">
            <p align="center"><b>Date de citation</b></p>
        </td>
        <td width="166" valign="top">
            <p align="center"><b>Date d’enregistrement</b></p>
        </td>
        <td width="65" valign="top">
            <p align="center"><b>Lire</b></p>
        </td>
    </tr>
    <?php
    include "dbFunctions.php";
    $citations = readCitations($pdo);
    foreach ($citations as $citation) {
        echo "<tr>
                    <td>$citation[Login]</td>
                    <td>$citation[Auteur]</td>
                    <td>$citation[Date_citation]</td>
                    <td>$citation[Date_enregistrement]</td>
                    <td><a href='viewCitation.php?id=$citation[id]'>Lire</a></td>
                </tr>";
    }
    ?>

</tbody>


</table>

