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
      <div id="loadImg"><div><img src="ajax-loader3.gif" /></div></div>
         <iframe border=0 name=iframe src="orari.php?name=<?php printf($_GET['name'].'&id='.$_GET['id']); ?>" width="100%" height="1800" scrolling="no" frameborder="0" onload="document.getElementById('loadImg').style.display='none';"></iframe>
       </body>
       </html>
