<?php
function show_programme($attrs){
	getTerms();
	$roles = get_option('OnlineScoutManager_activeRoles');
	$sectionid = $attrs['sectionid'];
	if (is_numeric($sectionid)) {
		if (isset($roles[$sectionid])) {
			$termid = $roles[$sectionid]['termid'];
			$section = $roles[$sectionid]['section'];

			$prog = get_cached_osm('programme'.$sectionid.'-'.$termid);
			if (!$prog) {
				$prog = osm_query('programme.php?action=getProgramme&sectionid='.$sectionid.'&termid='.$termid);
				if ($prog['items']) {
					foreach ($prog['items'] as $meeting) {
						$dateInSeconds = strtotime($meeting['meetingdate']);
						$storeProgramme[] = array('dateInSeconds' => strtotime($meeting['meetingdate']), 'date' => date("d/m/Y", $dateInSeconds), 'title' => $meeting['title'], 'summary' => $meeting['notesforparents']);
					}
				}
				update_cached_osm('programme'.$sectionid.'-'.$termid, $storeProgramme);
				$prog = $storeProgramme;
			}
			
			$string = '<table><tr><th>Date</th><th>Title</th><th>Details</th></tr>';
			foreach ($prog as $array) {				
				if (!(isset($attrs['futureonly']) or in_array('futureonly', $attrs)) or $array['dateInSeconds'] >= strtotime(date("Y-m-d"))) {
					$string .= '<tr>';
					$string .= '<td>'.$array['date'].'</td>';
					$string .= '<td>'.$array['title'].'</td>';
					$string .= '<td>'.$array['summary'].'</td>';
					$string .= '</tr>';
				}
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
add_shortcode('programme', 'show_programme');
?>