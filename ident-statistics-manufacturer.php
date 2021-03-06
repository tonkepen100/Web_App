<?php
require('require/class.Connection.php');
require('require/class.Spotter.php');

$spotter_array = Spotter::getSpotterDataByIdent($_GET['ident'],"0,1", $_GET['sort']);

if (!empty($spotter_array))
{
    $title = 'Most Common Aircraft Manufacturer of '.$spotter_array[0]['ident'];
	require('header.php');
    
    date_default_timezone_set('America/Toronto');
    
    print '<div class="info column">';
  		print '<h1>'.$spotter_array[0]['ident'].'</h1>';
  		print '<div><span class="label">Ident</span>'.$spotter_array[0]['ident'].'</div>';
  		print '<div><span class="label">Airline</span><a href="'.$globalURL.'/airline/'.$spotter_array[0]['airline_icao'].'">'.$spotter_array[0]['airline_name'].'</a></div>'; 
  		print '<div><span class="label">Flight History</span><a href="http://flightaware.com/live/flight/'.$spotter_array[0]['ident'].'" target="_blank">View the Flight History of this callsign</a></div>';       
	print '</div>';

	include('ident-sub-menu.php');
  
  print '<div class="column">';
  	print '<h2>Most Common Aircraft Manufacturer</h2>';
  	print '<p>The statistic below shows the most common Aircraft Manufacturer of flights using the ident/callsign <strong>'.$spotter_array[0]['ident'].'</strong>.</p>';

	  $manufacturers_array = Spotter::countAllAircraftManufacturerByIdent($_GET['ident']);
	
	  if (!empty($manufacturers_array))
	  {
	    print '<div class="table-responsive">';
		    print '<table class="common-manufacturer">';
		      print '<thead>';
		        print '<th></th>';
		        print '<th>Aircraft Manufacturer</th>';
		        print '<th># of Times</th>';
		        print '<th></th>';
		      print '</thead>';
		      print '<tbody>';
		      $i = 1;
		        foreach($manufacturers_array as $manufacturer_item)
		        {
		          print '<tr>';
		            print '<td><strong>'.$i.'</strong></td>';
		            print '<td>';
		              print '<a href="'.$globalURL.'/manufacturer/'.strtolower(str_replace(" ", "-", $manufacturer_item['aircraft_manufacturer'])).'">'.$manufacturer_item['aircraft_manufacturer'].'</a>';
		            print '</td>';
		            print '<td>';
		              print $manufacturer_item['aircraft_manufacturer_count'];
		            print '</td>';
		            print '<td><a href="'.$globalURL.'/search?manufacturer='.strtolower(str_replace(" ", "-", $manufacturer_item['aircraft_manufacturer'])).'&callsign='.$_GET['ident'].'">Search flights</a></td>';
		          print '</tr>';
		          $i++;
		        }
		      print '<tbody>';
		    print '</table>';
	    print '</div>';
	  }
  print '</div>';
  
  
} else {

	$title = "Ident";
	require('header.php');
	
	print '<h1>Error</h1>';

  print '<p>Sorry, this ident/callsign is not in the database. :(</p>';
}


?>

<?php
require('footer.php');
?>