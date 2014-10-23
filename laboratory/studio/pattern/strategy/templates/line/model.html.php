<html>
	<head>
		<title>
			{{ object.title }}
		</title>
	</head>
	<body>
		<h1>List View</h1>
		<h2>
			{{ object.title }}
		</h2>
		<p>
			{{ object.description }}
		</p>
		<hr />
		{% for obj in object->objects %}
			<h3>
				{{ obj.title }}
			</h3>
			<p>
				{{ obj.description }}
			</p>
			<hr />
		{% endfor %}
	</body>
</html>