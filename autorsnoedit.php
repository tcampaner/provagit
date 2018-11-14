<?php
 // Constants
 define('FILES_PER_PAGINA',10);
 // recollida estat
 $ordre=isset($_POST['ordre'])?$_POST['ordre']:'nom_aut';
 $sentit=isset($_POST['sentit'])?$_POST['sentit']:'asc';
 $filtre=isset($_POST['filtre'])?$_POST['filtre']:'';
 $pagina=isset($_POST['pagina'])?$_POST['pagina']:1;
 $quantitat=FILES_PER_PAGINA;  //tuples per pàgina
 // Connexió
 require_once("funcionsbd.php");
 $con=connexio();
 // Cercar el n. de tuples
 $sql="select count(*) as n from autors where id_aut like '$filtre%' or "
         . "nom_aut like '%$filtre%'";
 $cursor=consulta($con,$sql);
 while ($row=$cursor->fetch_assoc()) {
  $tuples=$row['n'];
  $pagines=ceil($tuples/$quantitat);
 }
 // Accions a fer
 if (isset($_POST['find'])) {  // Si canvia el filtre anam a la primera pagina
  $pagina=1;   
 } 
 if (isset($_POST['first'])) {
  $pagina=1;   
 }
 if (isset($_POST['last'])) {
  $pagina=$pagines;   
 }
 if (isset($_POST['before'])) {
  if ($pagina>1) {   
   $pagina--;   
  }
 }
 if (isset($_POST['next'])) {
  if ($pagina<$pagines) {   
   $pagina++;   
  }
 } 
 // calcul de la pagina
 $tupla=($pagina-1)*$quantitat;
 // Consulta
 $sql="select id_aut,nom_aut from autors where id_aut like '$filtre%' or "
         . "nom_aut like '%$filtre%' order by $ordre $sentit limit $tupla,$quantitat";
 $cursor=consulta($con,$sql);
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
            <h3 class="text-muted">Llistat d'autors</h3>            
            <div class="form-group">
              <input type="text" form="formulari" id="filtre" name="filtre" value="<?=$filtre?>">
              <input type="submit" name="find" value="..." form="formulari" class="btn btn-default">
            </div>
        </div>        
        <div>
            <hr>
            <table class="table table-bordered">
                <tr>
                    <th id="thIdAut">Codi</th><th id="thNomAut">Autor</th>
                </tr>
                <?php
                   while ($row=$cursor->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='col-md-2'>{$row["id_aut"]}</td>";
                      echo "<td class='col-md-8'>{$row["nom_aut"]}</td>";                      
                      echo "</tr>";  
                   }                
                ?>
            </table>      
        </div>
        <div class="btn-group" role="group">
          <form id="formulari" method="post" action="#" class="form-horizontal">
            <input type="hidden" name="ordre" value="<?=$ordre?>" id="ordre"/>
            <input type="hidden" name="sentit" value="<?=$sentit?>" id="sentit"/>            
            <input type="hidden" name="pagina" value="<?=$pagina?>" id="pagina"/>
            <input type="submit" name="first" value="<<" class="btn btn-secondary">
            <input type="submit" name="before" value="<" class="btn btn-secondary">
            <input type="submit" name="next" value=">" class="btn btn-secondary">
            <input type="submit" name="last" value=">>" class="btn btn-secondary">
          </form>
        </div>        
        <?php echo "$pagina/$pagines"; ?> 
       </div>
        <!-- Javascripts -->
        <script src="js/autorsnoedit.js"></script>
    </body>
</html>
