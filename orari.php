<!DOCTYPE html>
<html>
<head>
 <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
<meta charset=utf-8 />
<style type="text/css">
body,td,th {
font-family: "Open Sans";
font-size: 14px;
}
</style>
</head>
<?php
ini_set('memory_limit', '4048M');
ini_set('max_execution_time', '180');
flush();
$idstop=$_GET["id"];
$idname=$_GET["sname"];
$trip_idt=$_GET["trip_idt"];
$service_idt=$_GET["service_idt"];
$route_idt=$_GET["route_idt"];
$service_idc=$_GET["service_idc"];
$route_idr=$_GET["route_idr"];
$route_long_namer=$_GET["route_long_namer"];
$route_short_namer=$_GET["route_short_namer"];
$stop_ids=$_GET["stop_ids"];
$stop_arrives=$_GET["stop_arrives"];
$trip_ids=$_GET["trip_ids"];
$calendar_monday=$_GET["calendar_monday"];
$start_date=$_GET["start_date"];
$end_date=$_GET["end_date"];
//debug
//echo $trip_idt.",".$service_idt.",".$route_idt.",".$service_idc.",".$route_idr.",".$route_long_namer.",".$route_short_namer.",".$stop_ids.",".$stop_arrives.",".$trip_ids."</br>";
//$homepage1c=false;
date_default_timezone_set("Europe/Rome");
$ora=date("H:i:s", time());
echo "<b>".$idname."</b></BR>".$ora.", arrivi pianificati nella prossima ora:</BR></BR>";
echo get_stopid($idstop);

function get_corse($corsa)
    {
  GLOBAL $service_idt;
    GLOBAL $trip_idt;
      GLOBAL $route_idt;
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
    //  $trip_id="0";
    //  $service_id="0";
    //  $route_id="0";
      foreach($csv as $data=>$csv1){
    //  if ($csv[0][$count]=="trip_id") $trip_id=$count;
    //  if ($csv[0][$count]=="service_id") $service_id=$count;
    //  if ($csv[0][$count]=="route_id") $route_id=$count;

        $count++;

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
        $filter= $csv[$i][$trip_idt];

        if ($filter==$corsa){
      //  echo $csv[$i][$trip_idt]."</br>";
      //  echo $csv[$i][$route_idt]."</br>";

        $homepage1c =get_calendar($csv[$i][$service_idt]);
      //  echo "homepage ".$homepage1c."</br>";
    if ($homepage1c==true) $homepage =get_linee($csv[$i][$route_idt])."</br>";
      //  else $homepage =get_linee($csv[$i][0])." nel giorno ".$homepage1c." </br>";
}
    }
return   $homepage;
}
function get_calendar($linea)
    {
      GLOBAL $service_idc;
      GLOBAL $calendar_monday;
      GLOBAL $start_date;
      GLOBAL $end_date;
      $numero_giorno_settimana = date("w");
      $today = date("Ymd");
      $linea=trim($linea);
      $giornoposizione=3; // inserire la posizione del Monday in calendar.txt
      if ($numero_giorno_settimana ==0) $giornoposizione=$calendar_monday+6;
      if ($numero_giorno_settimana ==1) $giornoposizione=$calendar_monday;
      if ($numero_giorno_settimana ==2) $giornoposizione=$calendar_monday+1;
      if ($numero_giorno_settimana ==3) $giornoposizione=$calendar_monday+2;
      if ($numero_giorno_settimana ==4) $giornoposizione=$calendar_monday+3;
      if ($numero_giorno_settimana ==5) $giornoposizione=$calendar_monday+4;
      if ($numero_giorno_settimana ==6) $giornoposizione=$calendar_monday+5;
    //  echo "oggi è: ".$numero_giorno_settimana."</br>";
    //  echo "giornoposizione: ".$giornoposizione."</br>";
    $url1="gtfs/calendar.txt";
    $inizio1=1;
    $homepage1 =0;
  //  $service_id="0";
   //echo $url1;
    $csv1 = array_map('str_getcsv', file($url1));
    $count1 = 0;

    foreach($csv1 as $data1=>$csv11){

    //    if ($csv1[0][$count1]=="service_id") $service_id=$count1;
      $count1 = $count1+1;
    }
    //  echo "oggi: ".$numero_giorno_settimana."</br>";
    for ($ii=$inizio1;$ii<$count1;$ii++){
      $filter1= $csv1[$ii][$service_idc];

    //  echo $csv1[$ii][$numero_giorno_settimana]."</br>";
      if ($filter1==$linea){

      if ($csv1[$ii][$giornoposizione]==1) {
        if ($today >=$csv1[$ii][$start_date] && $today >=$csv1[$ii][$end_date]){
      $homepage1=1;
    }
  //    echo "filtro".$filter1."</br>";
  //      echo "giorno sett ".$csv1[$ii][7]."</br>";
  //    echo "homepage: ".$homepage1."</br>";
      //  echo $csv1[$ii][$giornoposizione]."</br>";
    }
      //  echo $csv1[$ii][0]."</br>";

      //$homepage1=$csv1[0][$numero_giorno_settimana];
    //  else $homepage1=1;
  }
      }

  return   $homepage1;
  }
function get_linee($linea)
    {
      GLOBAL $route_idr;
      GLOBAL $route_short_namer;
      GLOBAL $route_long_namer;
      $linea=trim($linea);

    $url1="gtfs/routes.txt";
    $inizio1=0;
    $homepage1 ="";
   //echo $url1;
    $csv1 = array_map('str_getcsv', file($url1));
    $count1 = 0;
  //    $route_id="0";
  //    $route_long_name="0";
  //    $route_short_name="0";
    foreach($csv1 as $data1=>$csv11){
  //      if ($csv1[0][$count1]=="route_short_name") $route_short_name=$count1;
  //      if ($csv1[0][$count1]=="route_long_name") $route_long_name=$count1;
  //      if ($csv1[0][$count1]=="route_id") $route_id=$count1;
      $count1 = $count1+1;
    }
    if ($count1 == 0){
      $homepage1="Nessuna linea";
    //  return   $homepage1;
    }

    if ($count > 80){
      $homepage1="errore generico linea";
    //  return   $homepage1;
    }
    //  echo $count;
    for ($ii=$inizio1;$ii<$count1;$ii++){
      $filter1= $csv1[$ii][$route_idr];

      if ($filter1==$linea){
      //  echo $filter1."</br>";
      $homepage1 =$csv1[$ii][$route_short_namer]."</br>(".$csv1[$ii][$route_long_namer].")";
    }
    }

  return   $homepage1;
  }
  function get_stopid($linea)
      {
GLOBAL $stop_arrives;
GLOBAL $stop_ids;
GLOBAL $trip_ids;

      date_default_timezone_set("Europe/Rome");
      $ora=date("H:i:s", time());
      $ora2=date("H:i:s", time()+ 60*60);
      //  $ora2="09:30:00"; //debug
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
  //    $stop_id="0";
  //    $stop_arrive="0";
  //    $trip_id="0";
      foreach($csv as $data1=>$csv11){
    //    if ($csv[0][$count]=="stop_id") $stop_id=$count;
    //    if ($csv[0][$count]=="arrival_time") $stop_arrive=$count;
    //    if ($csv[0][$count]=="trip_id") $trip_id=$count;
        $count++;
      }

        for ($i=$inizio;$i<$count;$i++)
        {

          if ($csv[$i][$stop_arrives] <=$ora2 && $csv[$i][$stop_arrives] >$ora) {

            $filter1= $csv[$i][$stop_ids];
            //echo $filter1;
        if ($filter1==$linea){
        //   array_push($distanza[$i]['orario'],$csv[$i][1]);
          $distanza[$i]['orario']=$csv[$i][$stop_arrives];

            $distanza[$i]['linea']=get_corse($csv[$i][$trip_ids]);
            $c++;

        // echo "linea".$distanza[$i]['linea'];
          }
        }
          }
      if ($c == 0){
        $homepage1="<b>Non ci sono corse nella prossima ora!</b>";
      }
      if ($c > 80){
        $homepage1="errore generico linea";
      }
      sort($distanza);
    //  var_dump($distanza);
      for ($ii=0;$ii<$c;$ii++)
      {
        if (strpos($distanza[$ii]['linea'],')') !== false){

        $homepage1 .="La linea ".$distanza[$ii]['linea']."passa alle ".$distanza[$ii]['orario']."<br>---------<br>";
      }
      }
  //echo "c:".$c."</br>";
    return   $homepage1;
    }

  ?>

<body>
</body>
</html>
