<div class="wrapper">
  <fieldset>
  	<div class="option">  
      <label for="wtitle">  
        <?php _e('Widget title', PLUGIN_LOCALE); ?>  
      </label>  
      <input type="text" id="<?php echo $this->get_field_id('wtitle'); ?>" name="<?php echo $this->get_field_name('wtitle'); ?>" value="<?php echo (strlen($instance['wtitle']) > 0) ? $instance['wtitle'] : "Coming Up"; ?>">  
    </div>
    <div class="option">
      <label for="section">
        <?php _e('Section', PLUGIN_LOCALE); ?>
      </label>
      <select id="<?php echo $this->get_field_id('sectionid'); ?>" name="<?php echo $this->get_field_name('sectionid'); ?>">
      <?php 
      $roles = get_option('online_scout_manager_active_roles');
      foreach ($roles as $role) {
      		echo '<option value="'.$role['sectionid'].'"';
			if ($instance['sectionid'] == $role['sectionid']) {
				echo ' selected="selected"';
			}
			echo '>'.$role['sectionname'].'</option>';
      }
      ?>
      </select>
    </div>
    <div class="option">  
      <label for="numentries">  
        <?php _e('Number of entries to show', PLUGIN_LOCALE); ?>  
      </label>  
      <select id="<?php echo $this->get_field_id('numentries'); ?>" name="<?php echo $this->get_field_name('numentries'); ?>"><option value="1"<?php echo ($instance['numentries'] == 1) ? ' selected="selected"' : '';?>>1</option><option value="2"<?php echo ($instance['numentries'] == 2) ? ' selected="selected"' : '';?>>2</option><option value="3"<?php echo ($instance['numentries'] == 3) ? ' selected="selected"' : '';?>>3</option><option value="4"<?php echo ($instance['numentries'] == 4) ? ' selected="selected"' : '';?>>4</option><option value="5"<?php echo ($instance['numentries'] == 5) ? ' selected="selected"' : '';?>>5</option></select>  
    </div>
    <div class="option">  
      <label for="numentries">  
        <?php _e('Display', PLUGIN_LOCALE); ?>  
      </label>  
      <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>"><option value="both"<?php echo ($instance['type'] == 'both') ? ' selected="selected"' : '';?>>Programme and Events</option><option value="programme"<?php echo ($instance['type'] == 'programme') ? ' selected="selected"' : '';?>>Programme</option><option value="events"<?php echo ($instance['type'] == 'events') ? ' selected="selected"' : '';?>>Events</option></select>  
    </div>  
  </fieldset>
</div>