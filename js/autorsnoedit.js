window.onload=function() {
 document.getElementById("thIdAut").onclick=ordenaIdAut;   
 document.getElementById("thNomAut").onclick=ordenaNomAut; 
 if (document.getElementById('ordre').value=='id_aut') {
  document.getElementById("thIdAut").className='selected';   
  document.getElementById('filtre').placeholder='Cercar per CODI..';
 } else {
  document.getElementById("thNomAut").className='selected';
  document.getElementById('filtre').placeholder='Cercar per NOM..';
 }
};

function ordenaIdAut() {
 if (document.getElementById('ordre').value=='id_aut') {
  canviSentit();   
 } else {
  document.getElementById('ordre').value='id_aut';
  document.getElementById('sentit').value='asc';  
 }  
 document.getElementById('pagina').value='1';
 document.getElementById('formulari').submit();
}

function ordenaNomAut() {
 if (document.getElementById('ordre').value=='nom_aut') {
  canviSentit();   
 } else {
  document.getElementById('ordre').value='nom_aut';
  document.getElementById('sentit').value='asc';  
 }    
 document.getElementById('pagina').value='1';
 document.getElementById('formulari').submit();
}

function canviSentit() {
 if (document.getElementById('sentit').value=='asc') {
  document.getElementById('sentit').value='desc';
 } else {  
  document.getElementById('sentit').value='asc';
 }      
}