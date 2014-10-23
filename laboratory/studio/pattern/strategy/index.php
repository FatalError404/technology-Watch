<?php
	namespace laboratory\studio\pattern\strategy;
	include_once('strategy.class.content.php');
	include_once('strategy.class.template.php');
	$title = 'Article Title';
	$description = 'Article Description';
	$content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis commodi ipsum perferendis a corporis nihil amet enim, deserunt earum repellendus neque! Nihil dolore doloribus et explicabo, eaque voluptatibus aspernatur obcaecati?'  ;
	$url = '//google.com';
	$object = new Content( $title, $description, $content, null, $url );
	
	$template = Template::instance( 'full', 'model.html.php' );
	$template->render( $object );
	
	$title = 'Folder Title';
	$description = 'Folder Description';
	$objects = array( $object, $object, $object );
	$object = new Content( $title, $description, $content, $objects );
	$template = Template::instance( 'line', 'model.html.php' );
	$template->render( $object ) ;
?>