<?php
function challenge_badges($attrs){
	getTerms();
	$roles = get_option('OnlineScoutManager_activeRoles');
	$sectionid = $attrs['sectionid'];
	if (is_numeric($sectionid)) {
		if (isset($roles[$sectionid])) {
			$termid = $roles[$sectionid]['termid'];
			$section = $roles[$sectionid]['section'];

			$summaryStructure = get_cached_osm('challengeSummary'.$section);
			if (!$summaryStructure) {
				$summaryStructure = osm_query('challenges.php?action=summaryStructure&section='.$section.'&sectionid='.$sectionid.'&termid=' . $termid. '&type=challenge');
				update_cached_osm('challengeSummary'.$section, $summaryStructure, 86400 * 30);
			}
			$string = "<table class='badgetbl'><tr><th>Name</th>";
			foreach ($summaryStructure[1]['rows'] as $column) {
				if ($column['field'] != 'scottish') {
					$string .= '<th>'.$column['name'].'</th>';
				}
			}
			$string .= '</tr>';
			$challenges = get_cached_osm('challengeDetails'.$sectionid);
			if (!$challenges) {
				$challenges = osm_query('challenges.php?action=summary&section='.$section.'&sectionid='.$sectionid.'&termid='.$termid.'&type=challenge');
				update_cached_osm('challengeDetails'.$sectionid, $challenges);
			}
			foreach ($challenges['items'] as $kid) {
				$string .= '<tr><td>'.$kid['firstname'].' '.substr($kid['lastname'], 0, 1).'</td>';
				foreach ($summaryStructure[1]['rows'] as $column) {
					if ($column['field'] != 'scottish') {
						$data = $kid[$column['field']];
						if (strtotime($data) > 0) {
							$data = date("d/m/Y", strtotime($data));
						}
						$string .= '<td>'.$data.'</td>';
					}
				}	
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
add_shortcode('challenge_badges', 'challenge_badges');
?>