<?php
ini_set('memory_limit', '6048M');
ini_set('max_execution_time', '360');
//ini_set('log_errors', 1);
//ini_set('error_log', '/var/log/httpd/error_log_fputs.txt');
//error_reporting(E_ALL);

function write($file,$string){
$fh = fopen($file, "w");
       if($fh==false)
           die("unable to create file");
       fputs ($fh, $string,strlen($string));
       echo $string;
       $success = fclose($fh);

   if ($success) {
        echo "File successfully closed!\n";
   } else {
        echo "Error on closing!\n";
   }

}

$url="gtfs/trips.txt";
  $inizio=0;
  $homepage ="";
 //  echo $url;
  $csv = array_map('str_getcsv', file($url));
  $count = 0;
  $trip_idt="0";
  $service_idt="0";
  $route_idt="0";
  foreach($csv as $data=>$csv1){
  if ($csv[0][$count]=="trip_id") $trip_idt=$count;
  if ($csv[0][$count]=="service_id") $service_idt=$count;
  if ($csv[0][$count]=="route_id") $route_idt=$count;

    $count++;

  }
  $url1="gtfs/calendar.txt";
  $inizio1=0;
  $homepage1 ="0";
  $service_idc="0";
 //echo $url1;
  $csv1 = array_map('str_getcsv', file($url1));
  $count1 = 0;
  foreach($csv1 as $data1=>$csv11){
      if ($csv1[0][$count1]=="service_id") $service_idc=$count1;
    $count1++;
  }
  $url1="gtfs/routes.txt";
  $inizio1=0;
  $homepage1 ="";
 //echo $url1;
  $csv1 = array_map('str_getcsv', file($url1));
  $count1 = 0;
    $route_idr="0";
    $route_long_namer="0";
    $route_short_namer="0";
  foreach($csv1 as $data1=>$csv11){
      if ($csv1[0][$count1]=="route_short_name") $route_short_namer=$count1;
      if ($csv1[0][$count1]=="route_long_name") $route_long_namer=$count1;
      if ($csv1[0][$count1]=="route_id") $route_idr=$count1;
    $count1++;
  }

  $url1="gtfs/stop_times.txt";
  $inizio=0;
  $homepage1 ="";
 //echo $url1;
  $orari=[];
  $row=0;
  $c=0;
  $csv = array_map('str_getcsv', file($url1));
  $count = 0;
  $stop_ids="0";
  $stop_arrives="0";
  $trip_ids="0";
  foreach($csv as $data1=>$csv11){

   if ($csv[0][$count]=="stop_id") $stop_ids=$count;
   if ($csv[0][$count]=="arrival_time") $stop_arrives=$count;
   if ($csv[0][$count]=="trip_id") $trip_ids=$count;
    $count++;
  }

$csv1 = array_map('str_getcsv', file('gtfs/stops.txt'));
//echo $csv1[0][0];
$count1 = 0;
$i=0;
$features = array();
$stop_desc="";
$stop_id="0";
$stop_code="";
$stop_name="";
$lat="";
$lon="";
  //if ($csv1[0][0]=="stop_id") echo "stopid num: ".$i;
foreach($csv1 as $i=>$data12){
  if ($csv1[0][$i]=="stop_id") $stop_id=$i;
  if ($csv1[0][$i]=="stop_desc") $stop_desc=$i;
  if ($csv1[0][$i]=="stop_name") $stop_name=$i;
  if ($csv1[0][$i]=="stop_code") $stop_code=$i;
  if ($csv1[0][$i]=="stop_lat") $lat=$i;
  if ($csv1[0][$i]=="stop_lon") $lon=$i;

}

foreach($csv1 as $csv11=>$data1){
  $count1 = $count1+1;


  if ($count1 >1)
  $features[] = array(
          'type' => 'Feature',
          'geometry' => array('type' => 'Point', 'coordinates' => array((float)$data1[$lon],(float)$data1[$lat])),
          'properties' => array('stop_desc' => $data1[$stop_desc],'stop_code' => $data1[$stop_code], 'stop_id' => $data1[$stop_id],'stop_name' => $data1[$stop_name],'stop_ids' =>$stop_ids,'stop_arrives' =>$stop_arrives,'trip_ids' =>$trip_ids,'route_short_namer' =>$route_short_namer,'route_long_namer' =>$route_long_namer,'route_idr' =>$route_idr,'service_idc' =>$service_idc,'trip_idt' =>$trip_idt,'service_idt' =>$service_idt,'route_idt' =>$route_idt)
          );
}

$allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
$geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);
//echo $stop_id." ".$stop_code." ".$stop_name." ".$stop_desc." ".$lat." ".$lon;
//echo $geostring;


$file = "json/mappaf.json";
write($file,$geostring);
//echo "finito";
?>
