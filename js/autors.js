window.onload=function() {
 document.getElementById("nouautor").style.display='none';      
 document.getElementById("thIdAut").onclick=ordenaIdAut;   
 document.getElementById("thNomAut").onclick=ordenaNomAut;
 document.getElementById("btnAfegir").onclick=function () {
   document.getElementById("nouautor").style.display='block';  
   document.getElementById("btnAfegir").style.display='none';
 };
 document.getElementById("btnCancelar").onclick=function () {
   document.getElementById("nouautor").style.display='none';  
   document.getElementById("btnAfegir").style.display='block';
 };
 if (document.getElementById('ordre').value=='id_aut') {
  document.getElementById("thIdAut").className='selected';   
 } else {
  document.getElementById("thNomAut").className='selected';
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