<aside class="widget">
<?php
getTerms();
$patrols = get_cached_osm('patrols');
function osm_patrol_sort($a, $b) {
    if ($a['points'] == $b['points']) {
        return 0;
    }
    return ($a['points'] < $b['points']) ? 1 : -1;
}
$continue = true;
if (!$patrols) {
	$roles = get_option('OnlineScoutManager_activeRoles');
	if (!is_array($roles)) {
		$continue = false;
		echo '<p>Online Scout Manager account has not been configured.</p>';
	} else {
		$now = strtotime(date("Y-m-d"));
		foreach ($roles as $role) {
			$prog = osm_query('users.php?action=getPatrols&sectionid='.$role['sectionid'].'&termid='.$role['termid']);
			if ($prog['patrols']) {
				foreach ($prog['patrols'] as $patrol) {
					if ($patrol['patrolid'] > 0) {
						$storepatrols[$role['sectionid']][] = $patrol;
					}
				}
				if (is_array($storepatrols[$role['sectionid']])) {
					uasort($storepatrols[$role['sectionid']], 'osm_patrol_sort');
				}
			}
		}
		update_cached_osm('patrols', $storepatrols);
		$patrols = $storepatrols;
	}
}
$patrols = $patrols[$instance['sectionid']];
?>
<h3 class="widget-title"><?php echo $instance['wtitle']; ?></h3>
<?php
if ($continue) {
	if ($patrols) {
		$i = 0;
		echo '<table style="width: 100%" class="osm_patrols"><tr><th>Name</th><th class="points">Points</th></tr>';
		
		foreach ($patrols as $entry) {
			echo '<tr><td>'.$entry['name'].'</td><td class="points">'.$entry['points'].'</td></tr>';
		}
		echo '</table>';
	} else {
		echo '<p>No patrols could be found.</p>';
	}
}
?>
</aside>