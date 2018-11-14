<?php
 session_start();
 require_once("funcionsbd.php");
 $con=connexio();
 // Iniciar sessió?
 if (!isset($_SESSION['ordre'])) {
   $_SESSION['ordre']='nom_aut';
   $_SESSION['sentit']='asc';
   $_SESSION['filtre']='';
   $_SESSION['pagina']=1;
   $_SESSION['quantitat']=10;
 }
 // tuples per pàgina
 $quantitat=$_SESSION['quantitat'];  //tuples per pàgina 
 // Accions a fer
 if (isset($_POST['find'])) {
  $_SESSION['filtre']=$_POST['filtre'];   
 }
 $filtre=$_SESSION['filtre'];
 // Cercar el n. de tuples
 $sql="select count(*) as n from autors where id_aut like '%$filtre%' or "
         . "nom_aut like '%$filtre%'";
 $cursor=consulta($con,$sql);
 while ($row=$cursor->fetch_assoc()) {
  $tuples=$row['n'];
  $pagines=ceil($tuples/$quantitat);
 }

 if (isset($_POST['first'])) {
  $_SESSION['pagina']=1;   
 }
 if (isset($_POST['last'])) {
  $_SESSION['pagina']=$pagines;   
 }
 if (isset($_POST['before'])) {
  if ($_SESSION['pagina']>1) {   
   $_SESSION['pagina']--;   
  }
 }
 if (isset($_POST['next'])) {
  if ($_SESSION['pagina']<$pagines) {   
   $_SESSION['pagina']++;   
  }
 }
 if (isset($_POST['codup'])) {
  $_SESSION['ordre']='id_aut';
  $_SESSION['sentit']='asc';
  $_SESSION['pagina']=1;
 }
 if (isset($_POST['coddown'])) {
  $_SESSION['ordre']='id_aut';
  $_SESSION['sentit']='desc';
  $_SESSION['pagina']=1;
 }
 if (isset($_POST['autup'])) {
  $_SESSION['ordre']='nom_aut';
  $_SESSION['sentit']='asc';
  $_SESSION['pagina']=1;
 }
 if (isset($_POST['autdown'])) {
  $_SESSION['ordre']='nom_aut';
  $_SESSION['sentit']='desc';
  $_SESSION['pagina']=1;
 }
 
 // recollida estat després de fer les accions, millor fer servir variables
 $pagina=$_SESSION['pagina'];
 $ordre=$_SESSION['ordre'];
 $sentit=$_SESSION['sentit'];
  
 // calcul de la pagina
 $tupla=($pagina-1)*$quantitat;
 // Consulta 
 $sql="select id_aut,nom_aut from autors where id_aut like '%$filtre%' or "
         . "nom_aut like '%$filtre%' order by $ordre $sentit limit $tupla,$quantitat";
 $cursor=consulta($con,$sql);
 // classe dels botons d'ordenar: per mostrar l'ordre canviant l'aspecte dels botons
 $classautup=$_SESSION['ordre']=='nom_aut' && $_SESSION['sentit']=='asc'?'btn-primary':'btn-secondary';
 $classautdown=$_SESSION['ordre']=='nom_aut' && $_SESSION['sentit']=='desc'?'btn-primary':'btn-secondary';
 $classcodup=$_SESSION['ordre']=='id_aut' && $_SESSION['sentit']=='asc'?'btn-primary':'btn-secondary';
 $classcoddown=$_SESSION['ordre']=='id_aut' && $_SESSION['sentit']=='desc'?'btn-primary':'btn-secondary';
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Biblioteca IES Pau Casesnoves. Autors.</title>
        <!-- Stylesheets -->
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">        
    </head>
    <body>
        <div class="container">
        <!-- Navbar -->
        <div  class="header clearfix">
         <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Afegir</a></li>
          </ul>
         </nav>
         <h3 class="text-muted">Llistat d'autors</h3>            
            <div class="form-group">
              <input type="text" form="formulari" id="filtre" name="filtre" placeholder="Cerca un llibre amb el titol" value="<?=$filtre?>">
              <input type="submit" name="find" value="..." form="formulari" class="btn btn-default">
            </div>
        </div>        
        <div>            
            <hr>
            <table class="table table-bordered">
                <tr><th id="thIdAut">
                        Codi&nbsp;&nbsp;
                        <div class="btn-group">
                         <input type="submit" name="codup" value="0" form="formulari" class="btn <?=$classcodup?>">
                         <input type="submit" name="coddown" value="9" form="formulari" class="btn <?=$classcoddown?>">                            
                        </div>
                    </th>
                    <th id="thNomAut">
                        Autor&nbsp;&nbsp;
                        <div class="btn-group">
                         <input type="submit" name="autup" value="A" form="formulari" class="btn <?=$classautup?>">
                         <input type="submit" name="autdown" value="Z" form="formulari" class="btn <?=$classautdown?>">                            
                        </div>                        
                    </th>
                 </tr>
                <?php
                   while ($row=$cursor->fetch_assoc()) {
                     echo "<tr>";
                     echo "<td>{$row["id_aut"]}</td><td>{$row["nom_aut"]}</td>";
                     echo "</tr>";  
                   }                
                ?>
            </table>      
        </div>
        <div class="btn-group" role="group">
          <form id="formulari" method="post" action="#">
            <input type="submit" name="first" value="<<" class="btn btn-secondary">
            <input type="submit" name="before" value="<" class="btn btn-secondary">
            <input type="submit" name="next" value=">" class="btn btn-secondary">
            <input type="submit" name="last" value=">>" class="btn btn-secondary">
          </form>
          <?php echo "$pagina/$pagines"; ?>  
        </div>        
       </div>
    </body>
</html>
