<?php //printf($_GET['id']); ?>
<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<style>

    #loadImg{
      position:absolute;
      left:35%;
      top:35%;

    }

  </style>
  <script>
window.onload=function(){
var iframe=document.getElementById('mioIFRAME');
 if(iframe){
    var altezza = iframe.contentWindow.document.body.scrollHeight;
    iframe.height = altezza+"px";
 }
}
</script>
      <div id="loadImg"><div><img src="ajax-loader3.gif" /></div></div>
         <iframe id="mioIFRAME" border=0 name=iframe src="orari.php?name=<?php printf($_GET['name'].'&id='.$_GET['id']); ?>" width="100%" height="1800" scrolling="no" frameborder="0" onload="document.getElementById('loadImg').style.display='none';"></iframe>
       </body>
       </html>
