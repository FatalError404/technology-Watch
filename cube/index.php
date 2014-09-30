<html>
	<head>
		<title>Cube Three.js</title>
		<link rel="stylesheet" title="home" href="../css/main.css">
	</head>
	<body>
		<div id="container"></div>
		<script src="../js/three.min.js"></script>
		<script>
		
			// on construit la scene la camera et le renderer
			var scene = new THREE.Scene();
			var camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );

			var renderer = new THREE.WebGLRenderer();
			renderer.setSize( window.innerWidth, window.innerHeight );
			document.body.appendChild( renderer.domElement );

			// background
			renderer.setClearColor(new THREE.Color(0xEEEEEE, 1.0));
        	renderer.setSize(window.innerWidth, window.innerHeight);
        	renderer.shadowMapEnabled = true;

			
			// on y introduit des objets
			var geometry = new THREE.CubeGeometry(1,1,1);
			var material = new THREE.MeshBasicMaterial( { color: 0x330000, side: THREE.BackSide } );
			// cube
			var cube = new THREE.Mesh( geometry, material );
			scene.add( cube );

			camera.position.z = 5;
			// on envoit la requete de rendu
			function render() {
				requestAnimationFrame(render);
				// on genere un mouvement
				cube.rotation.x += 0.1;
				cube.rotation.y += 0.1;
				renderer.render(scene, camera);
			}
			render();
			
			
		</script>
	</body>
</html>