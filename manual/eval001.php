<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<script language="JavaScript">
    
    parent.show();
    
</script>

<HTML>
<head>
    <title><?php echo $name_sistema; ?></title>
    <SCRIPT language="JavaScript" src="../applet/funciones_uneg.js"></SCRIPT>
    <link href="../estilos_css/sistemas.css" rel="stylesheet" type="text/css">
    
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    
<table width="100%" border="0"  height="440" cellpadding="0" cellspacing="0">
	<tr> 
    	<td colspan="2" align="center" valign="top" height="350"> 
            <table width="100%" border="0" >
            <tr> 
                <td height="10" valign="top" align="left" width="100%" class="barraPage"> 
                    <div align="left"><b>Manual  &gt; Sistema de Evaluación</b></div>
		</td>
            </tr>
</table>
   
            
<?php 
   //VERIFICAR SI ES COORDINADOR
   echo "<embed src=\"documento.pdf\" type=\"application/pdf\" width=\"100%\" height=\"800\">";
  
  
?>        
            
</BODY>
</HTML> 