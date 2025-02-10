<html>
Isto é HTML, mas de seguida vem XML:<br><div>
<?php

   $xslDoc = new DOMDocument();
   $xslDoc->load("visualiza_tabelav3.xslt");

   $xmlDoc = new DOMDocument();
   $xmlDoc->load("visualiza_tabelav3.xml");

   $proc = new XSLTProcessor();
   $proc->importStylesheet($xslDoc);
   echo $proc->transformToXML($xmlDoc);
   
   
   
?>
   </div>
   <form action="http://www.dn.pt" method="get">
    <input type="submit" value="Go to my link location" 
         name="Submit" id="frm1_submit" />
   </form>
</html>
