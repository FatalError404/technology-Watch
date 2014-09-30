<html>
	<head>
		<title>Sphere Three.js</title>
		<link rel="stylesheet" title="home" href="../css/main.css">
	</head>
	<body>
		<div id="container"></div>
		<script src="../js/three.min.js"></script>
		<script>
			var renderer, scene, camera, mesh;

			init();
			animate();

			function init(){
			    // on initialise le moteur de rendu
			    renderer = new THREE.WebGLRenderer({ antialias: true });

			    // si WebGL ne fonctionne pas sur votre navigateur vous pouvez utiliser le moteur de rendu Canvas à la place
			    // renderer = new THREE.CanvasRenderer();
			    renderer.setSize( window.innerWidth, window.innerHeight );
			    document.getElementById('container').appendChild(renderer.domElement);

			    // on initialise la scène
			    scene = new THREE.Scene();

			    // on initialise la camera que l’on place ensuite sur la scène
			    camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 1, 10000 );
			    camera.position.set(0, 0, 1000);
			    scene.add(camera);
			    
				// on créé la sphère et on lui applique une texture sous forme d’image
				var geometry = new THREE.SphereGeometry( 200, 32, 32 );
				var material = new THREE.MeshBasicMaterial( { map: THREE.ImageUtils.loadTexture('../images/Earth.png', new THREE.SphericalReflectionMapping()), overdraw: true } );
				mesh = new THREE.Mesh( geometry, material );
				scene.add( mesh );

				// on ajoute une lumière blanche
				var lumiere = new THREE.DirectionalLight( 0xffffff, 1.0 );
				lumiere.position.set( 0, 0, 400 );
				scene.add( lumiere );

			}

			function animate(){
			    requestAnimationFrame( animate );
			    mesh.rotation.x += 0.01;
			    mesh.rotation.y += 0.02;
			    renderer.render( scene, camera );
			}
		</script>
	</body>
</html>