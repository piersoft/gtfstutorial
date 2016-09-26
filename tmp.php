<?php //printf($_GET['id']; ?>
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
      <div id="loadImg">Attendere fino a 2 minuti..</br></br><div><img src="ajax-loader3.gif" /></div></div>
         <iframe id="mioIFRAME" border=0 name=iframe src="orari.php?name=<?php printf($_GET['name'].'&id='.$_GET['id'].'&stop_ids='.$_GET['stop_ids'].'&stop_arrives='.$_GET['stop_arrives'].'&trip_ids='.$_GET['trip_ids'].'&route_short_namer='.$_GET['route_short_namer'].'&route_long_namer='.$_GET['route_long_namer'].'&route_idr='.$_GET['route_idr'].'&service_idc='.$_GET['service_idc'].'&trip_idt='.$_GET['trip_idt'].'&service_idt='.$_GET['service_idt'].'&route_idt='.$_GET['route_idt'].'&calendar_monday='.$_GET['calendar_monday']); ?>" width="100%" scrolling="no" frameborder="0" onload="document.getElementById('loadImg').style.display='none';"></iframe>
     </body>
       </html>
