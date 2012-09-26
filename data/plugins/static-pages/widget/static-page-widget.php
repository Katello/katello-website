<?php 
/*
widget part of static-page plugin

*/
 
 /*
 
 class My_Widget extends WP_Widget {
	function My_Widget() {
		// widget actual processes
	}

	function form($instance) {
		// outputs the options form on admin
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
	}

	function widget($args, $instance) {
		// outputs the content of the widget
	}

}
register_widget('My_Widget');
*/
class kpg_static_page_widget extends WP_Widget {
    // private default list
    function kpg_static_page_widget() {
        parent::WP_Widget(false, $name = 'Static Page');
		/** constructor */
   }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
		extract($args);
	    $title=$instance['title'];
		$ssort=$instance['ssort'];
		// set the defaults
		if (!isset($title)) $title='Static Page';
		if (!isset($ssort)||empty($ssort)) $ssort='Title';
        $title = apply_filters('widget_title', $instance['title']);
		if ( $title ) {
			echo $before_title . $title . $after_title; 
		}
		// display stuff from recent list here
		$options=kpg_static_get_options();
		$recent=$options['recent'];
		// convert to an array and then sort it according to $ssort
        echo $before_widget;
		echo "<ul>";
		$display=array();
		foreach ($recent as $key=>$data) {
			// the key is the url - data is an array with $title,$now,count
			$title=$data[0];
			$title=trim($title);
			$cnt=str_pad($data[2],6,'0',STR_PAD_LEFT);
			if (empty($title)) $data[0]=$key;
			$rec=array($key,$data[0],$data[1],$data[2]);
			if ($ssort=='Title') {
				$display[$title.$key]=$rec;
			} else if ($ssort=='URL') {
				$display[$key]=$rec;
			} else if ($ssort=='Count') {
				$display[$cnt.$key]=$rec;
			} else {
				$display[$title.$key]=$rec;
			}
		}
		// $display has the code
		if ($ssort=='Count') {
			krsort($display);
		} else {
			ksort($display);
		}
		foreach($display as $key=>$rec) {
			$url=$rec[0];
			$title=$rec[1];
			$now=$rec[2];
			$count=$rec[3];
			echo "<li><a target=\"_self\" href=\"$url\">$title</a></li>";
		}
		echo "<ul>";
		?>
		<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ssort'] = strip_tags($new_instance['ssort']);
		return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		if(empty($instance)||!is_array($instance)) {
			$instance=array();
		}
		$defaults=array(
			'title'=>'Static Pages',
			'ssort'=>'Title'
		);
		$d=array_merge($instance,$defaults);
		extract($d);
        $title = esc_attr($title);
		$ssort = esc_attr($ssort);

       ?>
         <p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		<label for="<?php echo $this->get_field_id('ssort'); ?>"><?php _e('Sort Order:'); ?></label>
		<select id="<?php echo $this->get_field_id('ssort'); ?>" name="<?php echo $this->get_field_name('ssort'); ?>">
			<option value="Title" <?php if ($ssort=="Title") echo 'selected="selected"'; ?>>Sort by Title</option>
			<option value="URL" <?php if ($ssort=="URL") echo 'selected="selected"'; ?>>Sort by URL</option>
			<option value="Count" <?php if ($ssort=="Count") echo 'selected="selected"'; ?>>Sort by hit count descending</option>
		</select>
        </p>
        <?php 
    }

} // class kpg_static_page_widget


?>