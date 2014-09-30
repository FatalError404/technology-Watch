<?php if( empty($_SESSION) )session_start(); ?>
<!DOCTYPE html>
<html>
 <head> 
  <title>Teapot</title> 
  <script type="text/javascript" src="../js/three.min.js"></script> 
  <script type="text/javascript" src="../js/Detector.js"></script>
  <script type="text/javascript" src="../js/jquery-1.9.0.js"></script> 
  <script type="text/javascript" src="../js/stats.js"></script> 
  <script type="text/javascript" src="../js/dat.gui.js"></script> 
  <script type="text/javascript" src="../js/OrbitControls.js"></script>
  <script type="text/javascript" src="../js/ShaderPass.js"></script> 
  <script type="text/javascript" src="../js/CopyShader.js"></script> 
  <script type="text/javascript" src="../js/ColorifyShader.js"></script> 
  <script type="text/javascript" src="../js/BloomPass.js"></script> 
  <script type="text/javascript" src="../js/ConvolutionShader.js"></script> 
  <script type="text/javascript" src="../js/EffectComposer.js"></script> 
  <script type="text/javascript" src="../js/MaskPass.js"></script> 
  <script type="text/javascript" src="../js/FilmPass.js"></script> 
  <script type="text/javascript" src="../js/FilmShader.js"></script> 
  <script type="text/javascript" src="../js/SepiaShader.js"></script> 
  <script type="text/javascript" src="../js/RenderPass.js"></script> 
  <script type="text/javascript" src="../js/SavePass.js"></script> 
  <script type="text/javascript" src="../js/TexturePass.js"></script>
  <script type="text/javascript" src="../js/webaudio.js"></script> 
  <link rel="stylesheet" title="home" href="../css/main.css">
 </head> 
 <body> 
  <div id="Stats-output"></div>
  <div id="WebGL-output"></div>  
  <script type="text/javascript" src="../js/loader.js"></script>
  <h1>Upload ton modele et visualise le</h1>
  <?php
    if( in_array( 'file', $_SESSION) )
    {
      ?>
        <input id="file" type="hidden" value="<?php echo  $_SESSION['file']; ?>" />
      <?php
    }
  ?>
  <form action="/upload/model/" method="post" enctype="multipart/form-data">
      <input type="file" name="file" />
      <button type="submit">Upload</button>
  </form>
 </body>
</html>