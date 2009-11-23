<?php 
if ($story_comment['email_confirmed'] == 0) {
	print image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/delete.png', 'alt=pending');
	
}
elseif ($story_comment['email_confirmed'] == 1) {
	print image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/tick.png', 'alt=approved');
}
