/*  loader.js */
// once everything is loaded, we run our Three.js stuff.
$( document ).ready(function () {
    if( Detector.webgl && $('#file').length > 0 )
    {
    	console.log('toto');
       displayWebGlTeapot( $('#file') ) ;
    }
    else
    {
    	Detector.addGetWebGLMessage();
    }
});
/**
 *
 */
var displayWebGlTeapot = function( jq_object )
{
	var camera, scene, renderer, mesh, loader, speed_rotation, orbitControls, clock, stats;

	init();
	//
	function init() {
		stats = initStats();
		speed_rotation = Math.PI / 2 / 360 ;
	    camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 10000 );
	    camera.position.z = 1000;
	    scene = new THREE.Scene();
	    loader = new THREE.JSONLoader();
	    loader.load( '../model/' + jq_object.val(), function( geometry ) {
	        mesh = new THREE.Mesh( geometry, new THREE.MeshNormalMaterial() );
	        mesh.scale.set( 100, 100, 100 );
	        mesh.position.y = 0;
	        mesh.position.x = 0;
	        scene.add( mesh );

		    var ambientLight = new THREE.AmbientLight(0x555555);
		    scene.add(ambientLight);

		    orbitControls = new THREE.OrbitControls(camera);
			orbitControls.autoRotate = false;
			clock = new THREE.Clock();

		    var directionalLight = new THREE.DirectionalLight(0xffffff);
		    directionalLight.position.set(1, 1, 1).normalize();
		    scene.add(directionalLight);

		    renderer = new THREE.WebGLRenderer();
		    renderer.setSize( window.innerWidth / 2, window.innerHeight / 2  );
			canvas = renderer.domElement ; 
			$("#WebGL-output").append(canvas);

	        render();
	    } );
	}
	//
	function render() {
		stats.update();
		requestAnimationFrame(render);
		delta = clock.getDelta();
	    orbitControls.update(delta);
		renderer.render(scene, camera);
	}
};
//
var initStats = function() {

    var stats = new Stats();
    stats.setMode(1); // 0: fps, 1: ms
    $("#Stats-output").append(stats.domElement);
    return stats;
};
