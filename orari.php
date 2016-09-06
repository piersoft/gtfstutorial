<?php
flush();
$idstop=$_GET["id"];
$idname=$_GET["name"];
$homepage1c=false;
echo "<b>Fermata ".$idname."</b></BR>Arrivi pianificati nella prossima ora:</BR></BR>";
echo get_stopid($idstop);
//echo get_corse(579);

function get_corse($corsa)
    {

      $corsa=trim($corsa);
    //  $titolo=str_replace("à","%E0",$titolo);
    //  $corsa1="".$corsa;
    //  echo $corsa;
      $url="gtfs/trips.txt";
      $inizio=0;
      $homepage ="";
     //  echo $url;
      $csv = array_map('str_getcsv', file($url));
      $count = 0;
      foreach($csv as $data=>$csv1){
        $count = $count+1;

      }
      if ($count == 0){
        $homepage="Nessun corsa";
      //  return   $homepage;
      }
      if ($count > 40){
      //  $homepage="errore generico corsa";
      //  return   $homepage;
      }

    //  echo $count;
      for ($i=$inizio;$i<$count;$i++){
        $filter= $csv[$i][2];

        if ($filter==$corsa){
      //  echo $csv[$i][0]."</br>";
        $homepage1c =get_calendar($csv[$i][1]);

    if ($homepage1c==true) $homepage =get_linee($csv[$i][0])."</br>";
      //  else $homepage =get_linee($csv[$i][0])." nel giorno ".$homepage1c." </br>";
}
    }
return   $homepage;
}
function get_calendar($linea)
    {
      $numero_giorno_settimana = date("w");
      $linea=trim($linea);

    $url1="gtfs/calendar.txt";
    $inizio1=0;
    $homepage1 ="";
   //echo $url1;
    $csv1 = array_map('str_getcsv', file($url1));
    $count1 = 0;
    foreach($csv1 as $data1=>$csv11){
      $count1 = $count1+1;
    }
    //  echo $count;
    for ($ii=$inizio1;$ii<$count1;$ii++){
      $filter1= $csv1[$ii][0];
    //  echo $numero_giorno_settimana." ".$csv1[$ii][$numero_giorno_settimana+1]."</br>";

      if ($filter1==$linea){
      if ($csv1[$ii][$numero_giorno_settimana]!=0) $homepage1=true;

      //$homepage1=$csv1[0][$numero_giorno_settimana];
    //  else $homepage1=1;
      }
    }

  return   $homepage1;
  }
function get_linee($linea)
    {
      $linea=trim($linea);

    $url1="gtfs/routes.txt";
    $inizio1=0;
    $homepage1 ="";
   //echo $url1;
    $csv1 = array_map('str_getcsv', file($url1));
    $count1 = 0;
    foreach($csv1 as $data1=>$csv11){
      $count1 = $count1+1;
    }
    if ($count1 == 0){
      $homepage1="Nessuna linea";
    //  return   $homepage1;
    }
    if ($count > 40){
      $homepage1="errore generico linea";
    //  return   $homepage1;
    }
    //  echo $count;
    for ($ii=$inizio1;$ii<$count1;$ii++){
      $filter1= $csv1[$ii][0];

      if ($filter1==$linea){
      //  echo $filter1."</br>";
      $homepage1 =$csv1[$ii][2]."</br>(".$csv1[$ii][3].")";
      }
    }

  return   $homepage1;
  }
  function get_stopid($linea)
      {

        date_default_timezone_set("Europe/Rome");

        $ora=date("H:i:s", time());
        $ora2=date("H:i:s", time()+ 60*60);
      //  $ora2="09:30:00"; debug
      //  $ora="08:30:00";
        $linea=trim($linea);
        $corsa1="".$linea;
      $url1="gtfs/stop_times.txt";
      $inizio=0;
      $homepage1 ="";
     //echo $url1;
     $orari=[];
      $row=0;
      $c=0;
      $csv = array_map('str_getcsv', file($url1));
      $count = 0;
      foreach($csv as $data1=>$csv11){
        $count = $count+1;
      }
        for ($i=$inizio;$i<$count;$i++)
        {

          if ($csv[$i][1] <=$ora2 && $csv[$i][1] >$ora) {

            $filter1= $csv[$i][3];

        if ($filter1==$linea){
        //   array_push($distanza[$i]['orario'],$csv[$i][1]);
          $distanza[$i]['orario']=$csv[$i][1];
          $distanza[$i]['linea']=get_corse($csv[$i][0]);
        //  var_dump($distanza[$i]);
          //  echo $csv[$i][0]."</br>";
          //  $homepage1 .="La linea ".get_corse($csv[$i][0])."passa alle ".$csv[$i][1]."<br>---------<br>";
              $c++;
          }
        }
          }
      if ($c == 0){
        $homepage1="non ci sono corse nella prossima ora";
      }
      if ($c > 80){
        $homepage1="errore generico linea";
      }
      sort($distanza);
    //  var_dump($distanza);
      for ($ii=0;$ii<$c;$ii++)
      {

      if ($distanza[$ii]['linea']!="")  $homepage1 .="La linea ".$distanza[$ii]['linea']."passa alle ".$distanza[$ii]['orario']."<br>---------<br>";

      }
  //echo "c:".$c."</br>";
    return   $homepage1;
    }

  ?>
