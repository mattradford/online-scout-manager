<div class="wrapper">
  <fieldset>
  	<div class="option">  
      <label for="wtitle">  
        <?php _e('Widget title', PLUGIN_LOCALE); ?>  
      </label>  
      <input type="text" id="<?php echo $this->get_field_id('wtitle'); ?>" name="<?php echo $this->get_field_name('wtitle'); ?>" value="<?php echo (strlen($instance['wtitle']) > 0) ? $instance['wtitle'] : "Patrols"; ?>">  
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
  </fieldset>
</div>