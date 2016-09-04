<?php

function geoJson ($locales)
    {
        $original_data = json_decode($locales, true);
        $features = array();

        foreach($original_data as $key => $value) {
            $features[] = array(
                    'type' => 'Feature',
                    'geometry' => array('type' => 'Point', 'coordinates' => array((float)$value['stop_lat'],(float)$value['stop_lon'])),
                    'properties' => array('stop_desc' => $value['stop_desc'],'stop_code' => $value['stop_code'], 'stop_id' => $value['stop_id'],'stop_name' => $value['stop_name']),
                    );
            };

        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);

    }


$file1 = "json/mappaf.json";
$csv1 = array_map('str_getcsv', file('gtfs/stops.txt'));
$count1 = 0;
$features = array();
//  var_dump($csv1);
foreach($csv1 as $csv11=>$data1){
  $count1 = $count1+1;
  //var_dump($data1);
  if ($count1 >1)
  $features[] = array(
          'type' => 'Feature',
          'geometry' => array('type' => 'Point', 'coordinates' => array((float)$data1[5],(float)$data1[4])),
          'properties' => array('stop_desc' => $data1[3],'stop_code' => $data1[1], 'stop_id' => $data1[0],'stop_name' => $data1[2]),
          );

}
$allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
$geostring=json_encode($allfeatures, JSON_PRETTY_PRINT);


$original_json_string = file_get_contents('gtfs/stops.txt', true);

$dest1 = fopen($file1, 'w');

//$geostring=geoJson($csv1);
//echo $geostring;
fputs($dest1, $geostring);

echo "finito";
?>
