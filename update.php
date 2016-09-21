<?php


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
          'properties' => array('stop_desc' => $data1[$stop_desc],'stop_code' => $data1[$stop_code], 'stop_id' => $data1[$stop_id],'stop_name' => $data1[$stop_name]),
          );

}
$allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
$geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);
//echo $stop_id." ".$stop_code." ".$stop_name." ".$stop_desc." ".$lat." ".$lon;


$original_json_string = file_get_contents('gtfs/stops.txt', true);
$file1 = "json/mappaf.json";
$dest1 = fopen($file1, 'w');

echo $geostring;
fputs($dest1, $geostring);

echo "finito";
?>
