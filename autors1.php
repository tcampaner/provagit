<?php
 // recollida estat
 $ordre=isset($_POST['ordre'])?$_POST['ordre']:'nom_aut_1';
 $sentit=isset($_POST['sentit'])?$_POST['sentit']:'asc';
 $filtre=isset($_POST['filtre'])?$_POST['filtre']:'';
 $pagina=isset($_POST['pagina'])?$_POST['pagina']:1;
 $quantitat=10;  //tuples per pàgina
 //
 require_once("funcionsbd.php");
 $con=connexio();
 // Cercar el n. de tuples
 //Alta

 if (isset($_POST['btnAlta'])) {
  $nom_aut=$_POST['nomautor'];   
  $sql="select max(id_aut) as n from autors";    
  $cursor=consulta($con,$sql); $max=1;
  while ($row=$cursor->fetch_assoc()) {
   $max=$row['n']+1;
  }
  $sql="insert into autors(id_aut,nom_aut) values($max,'$nom_aut')";
  $cursor=consulta($con,$sql);
  $pagina=1;
  $sentit='desc';
  $ordre='id_aut';
 } 
 // Borrar
 if ($codi_borrat=array_search("Borrar", $_POST)) {
     
  $sql="delete from autors where id_aut=$codi_borrat";
  $cursor=consulta($con,$sql);     
 }
 // Edicio
 $edicio='';
 if ($codi_borrat=array_search("Editar", $_POST)) {
  $edicio=$codi_borrat;
 }
 //Modifica
 if (isset($_POST['btnModificar'])) {
  $nom_aut=$_POST['Mod_nomautor'];   
  $id_aut=$_POST['Mod_idautor'];
  $sql="update autors set nom_aut='$nom_aut' where id_aut=$id_aut";
  $cursor=consulta($con,$sql);
 } 
 
 
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
         <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><button id="btnAfegir" class="btn btn-primary">Afegir</button></li>
          </ul>
         </nav>
            <h3 class="text-muted">Llistat d'autors</h3>            
            <div class="form-group">
              <input type="text" form="formulari" id="filtre" name="filtre" placeholder="Cerca un llibre amb el titol" value="<?=$filtre?>">
              <input type="submit" name="find" value="..." form="formulari" class="btn btn-default">
            </div>
        </div>        
        <div>
            <fieldset id="nouautor" class="afegirmig">  
            <div id="frmAfegir" class="form-group">            
               <legend class="formulari"></legend>                 
               <label for="nomautor" class="col-sm-2 control-label">Nou Autor</label>
               <div class="col-sm-6">            
                <input type="text" class="form-control" form="formulari" id="nomautor" name="nomautor" placeholder="" value="">
               </div>
               <div class="col-sm-4">
                <input type="submit" name="btnAlta" value="Afegir" form="formulari" class="btn btn-succes">
                <button id="btnCancelar" class="btn btn-danger">Cancel·lar</button>
               </div>                         
            </div>            
            </fieldset>                
            <hr>
            <table class="table table-bordered">
                <tr><th id="thIdAut">Codi</th><th id="thNomAut">Autor</th><th></th></tr>
                <?php
                   while ($row=$cursor->fetch_assoc()) {
                     if ($edicio==$row["id_aut"]) {
                      echo "<tr>";
                      echo "<td class='col-md-2'>{$row["id_aut"]}<input type='hidden' name='Mod_idautor' form='formulari' value='{$row["id_aut"]}'></td><td class='col-md-8'><input type='text' name='Mod_nomautor' value='{$row["nom_aut"]}' form='formulari' class='col-md-6'></td>";
                      echo "<td class='col-md-2'><button type='submit' class='btn btn-success btn-xs' form='formulari' name='btnModificar' value='Guardar'><span class='glyphicon glyphicon-ok'></span></button>&nbsp;&nbsp;<button type='submit' class='btn btn-danger btn-xs' form='formulari' name='btnCancelarMod' value='Cancel·lar'><span class='glyphicon glyphicon-remove'></span></button></td>";
                      echo "</tr>";                           
                     }  else {
                      echo "<tr>";
                      echo "<td class='col-md-2'>{$row["id_aut"]}</td><td class='col-md-8'>{$row["nom_aut"]}</td>";
                      echo "<td class='col-md-2'><button type='submit' class='btn btn-succes btn-xs' form='formulari' name='{$row["id_aut"]}' value='Editar'><span class='glyphicon glyphicon-pencil'></span></button>&nbsp;&nbsp;<button type='submit' class='btn btn-danger btn-xs' form='formulari' name='{$row["id_aut"]}' value='Borrar'><span class='glyphicon glyphicon-trash'></span></button></td>";
                      echo "</tr>";  
                     }
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
        <script src="js/autors.js"></script>
    </body>
</html>
