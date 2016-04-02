<div class="wrap">
	<h2>Online Scout Manager</h2>
	<p>Your ScoutSites.org.uk site has been setup with your Online Scout Manager account successfully.  If you want to add/remove sections, you must re-authorise ScoutsSites.org.uk.  If you want new updates on OSM to appear immediately, use the Purge cache option below, otherwise they will appear on the site within a day.</p>
	<form action="" method="post" style="float: left; margin-right: 10px;">
	<input type="hidden" name="mode" value="unauthorise" />
	<input class="button-primary" type="submit" value="Re-authorise" name="submit">
	</form>
	<form action="" method="post">
	<input type="hidden" name="mode" value="purgecache" />
	<input class="button-primary" type="submit" value="Purge cache" name="submit">
	</form>
	<?php if (strlen($authoriseErrorMsg) > 0) { echo '<span style="color: red;">'.$authoriseErrorMsg.'</span><br />';}?>
	<h2 style="font-size: 1.4em;">OSM Widgets</h2>
	<p>The widgets below can be setup by going to Appearance > Widgets, and then dragging the appropriate widget onto the appropriate sidebar.  Once you've done that, expand the new entry to configure it.  More widgets will become available in the future.</p>
	<p>If you are using the ScoutSites template, you'll have the choice of five sidebars - the 'Main Sidebar' and one for each section type.  The Main Sidebar appears on the right of the blog-style posts, and the remaining section-specific sidebars appear on the right of the section-specific pages.  You can pick which sidebar appears on new posts and pages by changing the template.</p>
	<h3>Coming Up</h3>
	<p>Displays the next events and/or meetings.</p>
	<h3>Patrol Points</h3>
	<p>Displays your patrol/six/lodge point competition.</p>
	<h2 style="font-size: 1.4em;">OSM Pages</h2>
	<h3>Challenge Badges</h3>
	<p>You can display the challenge badge state (due or awarded) for your members.  To do this, create a page and pick the 'Challenge Badge Template'.  Inside the page contents, type [challenge_badges sectionid=X] where X is your section identifier - see below for section identifiers.</p>
	<h3>Programme</h3>
	<p>You can display your programme (date, title and summary) on a page.  In any page that you want this to appear, type [programme sectionid=X] where X is your section identifier - see below.  If you only want to show future meetings, add 'futureonly' (i.e. [programme sectionid=X futureonly]).</p>
	<h3>Events</h3>
	<p>You can display your future events (start date, title and notes) on a page.  In any page that you want this to appear, type [events sectionid=X] where X is your section identifier - see below.</p>
	<?php
	$roles = get_option('OnlineScoutManager_activeRoles');
	$needToReFetch = false;
	foreach ($roles as $role) {
		if (!isset($role['section']) or strlen($role['section']) == 0) {
			$needToReFetch = true;
			break;
		}
	}
	if ($needToReFetch) {
		getRoles();
		resyncDataToActiveRoles();
		getTerms();
		$roles = get_option('OnlineScoutManager_activeRoles');
	}
	echo '<h2 style="font-size: 1.4em;">OSM Section Identifiers</h2>';
	echo '<table><tr><th>Group</th><th>Section</th><th>Section ID</th></tr>';
	foreach ($roles as $role) {
		echo '<tr><td>'.$role['groupname'].'</td><td>'.$role['sectionname'].'</td><td>'.$role['sectionid'].'</td></tr>';
	}
	echo '</table>';
	?>
</div>