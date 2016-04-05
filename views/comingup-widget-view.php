<aside class="widget">
<?php
osm_get_terms();
$continue = true;
$programme = get_cached_osm('programme');
if (!$programme) {
	$roles = get_option('online_scout_manager_active_roles');
	if (!is_array($roles)) {
		$continue = false;
		echo '<p>Online Scout Manager account has not been configured.</p>';
	} else {
		$now = strtotime(date("Y-m-d"));
		foreach ($roles as $role) {
			$prog = osm_query('programme.php?action=getProgramme&sectionid='.$role['sectionid'].'&termid='.$role['termid']);
			if ($prog['items']) {
				foreach ($prog['items'] as $meeting) {
					$dateInSeconds = strtotime($meeting['meetingdate']);
					if ($dateInSeconds >= $now) {
						$storeProgramme[$role['sectionid']][$dateInSeconds][] = array('type' => 'programme', 'date' => date("d/m/Y", $dateInSeconds), 'title' => $meeting['title'], 'summary' => $meeting['notesforparents']);
					}
				}
			}
			
			$prog = osm_query('events.php?action=getEvents&sectionid='.$role['sectionid'].'&termid='.$role['termid'].'&futureonly=true');
			if ($prog['items']) {
				$prog['items'] = array_reverse($prog['items']);
				
				foreach ($prog['items'] as $meeting) {
					$dateInSeconds = strtotime($meeting['startdate']);
					if ($dateInSeconds >= $now) {
						$storeProgramme[$role['sectionid']][$dateInSeconds][] = array('type' => 'events', 'date' => date("d/m/Y", $dateInSeconds), 'title' => $meeting['name'], 'summary' => $meeting['notes']);
					}
				}
			}
			if (is_array($storeProgramme[$role['sectionid']])) {
				ksort($storeProgramme[$role['sectionid']]);
			}
		}
		update_cached_osm('programme', $storeProgramme);
		$programme = $storeProgramme;
	}
}
$programme = $programme[$instance['sectionid']];
?>
<h3 class="widget-title"><?php echo $instance['wtitle']; ?></h3>
<?php
if ($continue) {
	if ($programme) {
		$i = 0;
		foreach ($programme as $array) {
			foreach ($array as $entry) {
				if ($instance['type'] == 'both' or ($instance['type'] == 'programme' and $entry['type'] == 'programme') or ($instance['type'] == 'events' and $entry['type'] == 'events')) {
					echo '<div class="osm_comingup_title">'.$entry['title'].'</div>';
					echo '<div class="osm_comingup_date">'.$entry['date'].'</div>';
					echo '<div class="osm_comingup_description">'.$entry['summary'].'</div>';
					$i++;
					if ($i >= $instance['numentries']) {
						break 2;
					}
				}
			}
		}
	} else {
		echo '<p>Current programme is unavailable.</p>';
	}
}
?>
</aside>
