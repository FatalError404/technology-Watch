<h1>List View</h1>
<h2>
	{{ object.title }}
</h2>
<p>
	{{ object.description }}
</p>
<p>
	<small>Description from an article directly from the main templte variable without any template operator:</small>
	<p>
		{{ object.objects[0].description }}
	</p>
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
<small>Variable direct in template:</small>
{% set setTemplateVariable = 'tadaaaaaa!' %}
<p>
	<strong>
		{{ $setTemplateVariable }}
	</strong>
</p>