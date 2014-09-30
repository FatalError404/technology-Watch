/*  main.js */


// once everything is loaded, we run our Three.js stuff.
$( document ).ready(function () {
    if( Detector.webgl )
    {
       displayWebGlPlanet() ;
    }
    else
    {
    	Detector.addGetWebGLMessage();
    }
});
/**
 *
 */
var displayWebGlPlanet = function()
{
	//var webaudio    = new WebAudio();
	/*var sound   = webaudio.createSound().load('../sounds/space-cowboy.mp3', function(sound){
	    sound.loop(true).play();
	});*/
	var stats = initStats();

	// create a scene, that will hold all our elements such as objects, cameras and lights.
	var scene = new THREE.Scene();
	var sceneBG = new THREE.Scene();

	//var sceneTeapot = new THREE.Scene();

	// create a camera, which defines where we're looking at.
	var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
	//var cameraTea = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);

	var cameraBG = new THREE.OrthographicCamera(-window.innerWidth, window.innerWidth, window.innerHeight, -window.innerHeight, -10000, 10000);
	cameraBG.position.z = 15;
	//cameraControls	= new THREE.DragPanControls(cameraBG) ;

	// create a render and set the size
	var webGLRenderer = new THREE.WebGLRenderer({ antialias: true });
	webGLRenderer.setClearColor(new THREE.Color(0x000, 1.0));
	webGLRenderer.setSize(window.innerWidth, window.innerHeight);
	webGLRenderer.shadowMapEnabled = true;


	var sphere = createMesh(new THREE.SphereGeometry(8, 50, 50));
	//sphere.position.x = -10;
	// add the sphere to the scene
	scene.add(sphere);

	//var teapot = createMeshFromModel('teapot.js', sceneTeapot ) ;

	var materialColor = new THREE.MeshBasicMaterial({ map: THREE.ImageUtils.loadTexture("../images/space.jpg"), depthTest: false });
	var bgPlane = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), materialColor);
	bgPlane.position.z = -100;
	bgPlane.scale.set(window.innerWidth * 2.920, window.innerHeight * 3.2, 1);
	sceneBG.add(bgPlane);

	// position and point the camera to the center of the scene
	camera.position.x = 15;
	camera.position.y = 15;
	camera.position.z = 15;

	camera.lookAt(new THREE.Vector3(0, 0, 0));

	var orbitControls = new THREE.OrbitControls(camera);
	orbitControls.autoRotate = false;
	var clock = new THREE.Clock();

	var ambi = new THREE.AmbientLight(0x333333);
	scene.add(ambi);
	//sceneTeapot.add(ambi) ;

	var spotLight = new THREE.DirectionalLight(0xffffff);
	spotLight.position.set(350, 350, 150);
	spotLight.intensity = 0.4;
	scene.add(spotLight);
	//sceneTeapot.add(spotLight);

	canvas = webGLRenderer.domElement ; 

	// add the output of the renderer to the html element
	$("#WebGL-output").append(canvas);

	var bgPass = new THREE.RenderPass(sceneBG, cameraBG);

	var renderPass = new THREE.RenderPass(scene, camera);
	renderPass.clear = false;

	//var renderTeapotPass = new THREE.RenderPass(sceneTeapot, cameraTea);
	//renderTeapotPass.clear = false;


	var effectCopy = new THREE.ShaderPass(THREE.CopyShader);
	effectCopy.renderToScreen = true;


	var clearMask = new THREE.ClearMaskPass();
	// earth mask
	var earthMask = new THREE.MaskPass(scene, camera);
	earthMask.inverse = true;

	// earth mask
	//var teapotMask = new THREE.MaskPass(sceneTeapot, cameraTea);
	//teapotMask.inverse = true;


	//var effectSepia = new THREE.ShaderPass(THREE.SepiaShader);
	//effectSepia.uniforms['amount'].value = 0.8;

	//var effectColorify = new THREE.ShaderPass(THREE.ColorifyShader);
	//effectColorify.uniforms[ 'color' ].value.setRGB(0.5, 0.5, 1);


	var composer = new THREE.EffectComposer(webGLRenderer);
	composer.renderTarget1.stencilBuffer = true;
	composer.renderTarget2.stencilBuffer = true;

	composer.addPass(bgPass);
	composer.addPass(renderPass);
	//composer.addPass(effectColorify);
	composer.addPass(clearMask);
	composer.addPass(earthMask);
	//composer.addPass(renderTeapotPass);
	//composer.addPass(clearMask);
	//composer.addPass(teapotMask);
	//composer.addPass(effectSepia);
	composer.addPass(clearMask);
	composer.addPass(effectCopy);

	var speed_rotation = Math.PI / 2 / 360 ;
	// call the render function
	render();

	function createMesh(geom) {


	    var planetTexture = THREE.ImageUtils.loadTexture("../images/Earth.png");
	    var specularTexture = THREE.ImageUtils.loadTexture("../images/EarthSpec.png");
	    var normalTexture = THREE.ImageUtils.loadTexture("../images/EarthNormal.png");


	    var planetMaterial = new THREE.MeshPhongMaterial();
	    planetMaterial.specularMap = specularTexture;
	    planetMaterial.specular = new THREE.Color(0x999999);
	    planetMaterial.shininess = 2;

	    planetMaterial.normalMap = normalTexture;
	    planetMaterial.map = planetTexture;
	    //   planetMaterial.shininess = 150;


	    // create a multimaterial
	    var mesh = THREE.SceneUtils.createMultiMaterialObject(geom, [planetMaterial]);

	    return mesh;
	}

	function createMeshFromModel( model, scene )
	{
		loader = new THREE.JSONLoader();
		loader.load( '../js/' + model , function( geometry ) {
	        teapot = new THREE.Mesh( geometry, new THREE.MeshNormalMaterial() );
	        teapot.scale.set( 10, 10, 10 );
	        teapot.position.y = 150;
	        teapot.position.x = 0;
	        scene.add( teapot ); 
	    } );
	}



	function render() {

	    webGLRenderer.autoClear = false;
	    stats.update();
	    var delta = clock.getDelta();
	    orbitControls.update(delta);
	    //sphere.rotation.y += delta / 10;
	    sphere.rotation.y += speed_rotation ;
	    // render using requestAnimationFrame
	    requestAnimationFrame(render);
	    /*amplitude = sound.amplitude() ;
	    if( amplitude > 0  )
	    {
	        //sphere.scale.x = amplitude ;
	        //sphere.scale.y = amplitude ;
	        //sphere.scale.z = amplitude ;
	    }*/
	    composer.render(delta);
	}
};

var initStats = function() {

    var stats = new Stats();
    stats.setMode(1); // 0: fps, 1: ms
    $("#Stats-output").append(stats.domElement);
    return stats;
};

var webgl_support = function() { 
	try{
	var canvas = document.createElement( 'canvas' ); 
	return !! window.WebGLRenderingContext && ( 
	     canvas.getContext( 'webgl' ) || canvas.getContext( 'experimental-webgl' ) );
	}catch( e ) { return false; } 
};
