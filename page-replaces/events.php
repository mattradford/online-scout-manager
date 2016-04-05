<?php
function show_events($attrs){
	osm_get_terms();
	$roles = get_option('online_scout_manager_active_roles');
	$sectionid = $attrs['sectionid'];
	
	if (is_numeric($sectionid)) {
		if (isset($roles[$sectionid])) {
			$termid = $roles[$sectionid]['termid'];
			$section = $roles[$sectionid]['section'];

			$events = get_cached_osm('events'.$sectionid);
			if (!$events) {
				$events = osm_query('events.php?action=getEvents&futureonly=true&sectionid='.$sectionid);
				$events['items'] = array_reverse($events['items']);
				if ($events['items']) {
					foreach ($events['items'] as $meeting) {
						$dateInSeconds = strtotime($meeting['startdate']);
						$storeEvents[] = array('date' => date("d/m/Y", $dateInSeconds), 'title' => $meeting['name'], 'summary' => $meeting['notes']);
						
					}
				}
				update_cached_osm('events'.$sectionid, $storeEvents);
				$events = $storeEvents;
			}
			
			$string = '<table><tr><th>Start date</th><th>Events</th><th>Extra details</th></tr>';
			foreach ($events as $array) {
				$string .= '<tr>';
				$string .= '<td>'.$array['date'].'</td>';
				$string .= '<td>'.$array['title'].'</td>';
				$string .= '<td>'.$array['summary'].'</td>';
				$string .= '</tr>';
			}
			$string .= '</table>';

			return $string;
		} else {
			return "There is no OSM data for the specified section.";
		}
		
	} else {
		return "A numeric sectionid must be provided.";
	}
 
}
add_shortcode('events', 'show_events');
?>