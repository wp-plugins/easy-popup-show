<?php
function themeData($id, $key) {		
		return get_post_meta($id, $key , true);
}
?>