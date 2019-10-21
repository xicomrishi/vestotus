<?php
	date_default_timezone_set("America/New_York");
	DEFINE('SITE_TITLE', 'Vestotus');
	DEFINE('BASEURL', 'http://132.148.244.89/~vestotus/');
	DEFINE('FILE_COURSE_THUMB',BASEURL.'uploads/courses/thumb/');
	DEFINE('FILE_COURSE',BASEURL.'uploads/courses/');
	DEFINE('CHAPTER_AUDIO',BASEURL.'uploads/courses/audio/');
	DEFINE('CHAPTER_VIDEO',BASEURL.'uploads/courses/videos/');
	DEFINE('CHAPTER_PPT',BASEURL.'uploads/courses/ppt/');
	DEFINE('COURSE_RESOURCE',BASEURL.'uploads/courses/resources/');
	DEFINE('COURSE_CERTIFICATES',BASEURL.'uploads/courses/certificates/');
	DEFINE('CHAPTER_AUDIO_ROOT',WWW_ROOT.'uploads/courses/audio/');
	DEFINE('CHAPTER_VIDEO_ROOT',WWW_ROOT.'uploads/courses/videos/');
	DEFINE('CHAPTER_PPT_ROOT',WWW_ROOT.'uploads/courses/ppt/');



	$config = array
	(		
		'gender_arr' => array(
			'male' => 1,
			'female' => 2
		),
		'spice_level' => array(
			1 => 'Normal',
			2 => 'Medium',
			3 => 'Spicy', 
		),
		'dish_type' => array(
			1 => 'Vegetarion',
			2 => 'Non Vegetarion'
		),		
	);
?>