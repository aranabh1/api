<?php 
/*
	filename 	: cis355api.php
	author   	: ABHISEKH RANABHAT
	course   	: cis355 (winter2020)
	description	: demonstrate JSON API functions
				  return number of new covid19 cases
	input    	: https://api.covid19api.com/summary
	functions   : main()
	                curl_get_contents()
*/

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';

	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);

	$death_arr = Array() ;

	foreach($obj->Countries as $i){
		$death_arr[$i->Country] = $i->TotalDeaths;
	}
	arsort($death_arr);

	// echo html head section
	echo '<html>';
	echo '<head>';
	echo '	<link rel="icon" href="img/cardinal_logo.png" type="image/png" />';
	echo"<b><a target='_blank' href='https://github.com/aranabh1/api.git'>GITHUB REPO</a><b> <br><br>";
	echo '<style>';
	echo "table, th, td {
			border: 2px solid blue;
	  	}";
	echo '</style>';
	echo '</head>';
	
	// open html body section
	echo '<body onload="loadDoc()">';

	// number of death people ranked from 1 to 10.
	$death_arr = array_slice($death_arr,0,10);
	$JSONString=json_encode($death_arr);
	$JSONObject = json_decode($JSONString); 


	echo 'JSON Object From $death_arr in descending order<br>';
	echo var_dump($JSONObject);
	echo '<br><br>';
	echo "<div><u><b>Table contaning data from covid19api.com</b><u><br><br>";
	echo "<table>";
        echo "<tr>";
		  	
            echo "<th>Country</th>";
            echo "<th>Total Number of Death Cases</th>";
		echo "</tr>";
		$i=1;
		foreach ($death_arr as $country => $cases) {
			echo "<tr>";
			echo "<td>{$country}</td>";
			echo "<td>{$cases}</td>";
			echo "</tr>";
			$i++;
		 }
	echo "</table>";
	echo '</div>';
	echo '</body>';
	echo '</html>';
}



#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>












