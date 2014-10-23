<html>
	<head>
		<title>
			<?php echo $object->title  ; ?>
		</title>
	</head>
	<body>
		<h1>List View</h1>
		<h2>
			<?php echo $object->title  ; ?>
		</h2>
		<p>
			<?php echo $object->description  ; ?>
		</p>
		<hr />
		<?php  foreach( $object->objects as $obj){ ?>
			<h3>
				<?php echo $obj->title  ; ?>
			</h3>
			<p>
				<?php echo $obj->description  ; ?>
			</p>
			<hr />
		<?php  }  ?>
	</body>
</html>