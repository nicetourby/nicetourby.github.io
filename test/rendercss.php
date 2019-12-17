<?php
if (isset($_POST["primary_color"]) || isset($_POST["base_color"]) || isset($_POST["head_font"]) || isset($_POST["body_font"]))
{ 
  $primary_color = $_POST["primary_color"];
  $base_color = $_POST["base_color"];
  $head_font = $_POST["head_font"];
  $body_font = $_POST["body_font"];

  require_once "lessphp/Less.php";
  try{
    $options = array( 'compress'=>false, 'relativeUrls' => false);
    $parser = new Less_Parser($options);
    $parser->parse( '@primary-color: '.$primary_color.';' );
    $parser->parse( '@base-color: '.$base_color.';' );
    $parser->parse( '@head-font: '.$head_font.';' );
    $parser->parse( '@body-font: '.$body_font.';' );

    
    $parser->parseFile( 'assets/less/compile/bootstrapcompile.less', '' );
    $parser->parseFile( 'assets/less/compile/jqueryuicompile.less', '' );
    $parser->parseFile( 'assets/less/compile/maincompile.less', '' );
    $css = $parser->getCss();
    echo $css;
  }
  catch(Exception $e){
    $error_message = $e->getMessage();
    echo $error_message;
  }
}

?>
