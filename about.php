<?php 
  $path2root = "";
  ob_start();
  try {
  include('./assets/inc/title.inc.php'); 
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <?php include('./assets/inc/head.inc.php'); ?>
</head>
<body id="about">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 9]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

  <div class="modal fade" id="myModal">
    <div class="modal-header">
      <a class="close" data-dismiss="modal">×</a>
      <h3>Modal header</h3>
    </div>
    <div class="modal-body">
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn btn-inverse">Ok</a>
    </div>
  </div>

<!-- ## HEADER & NAV ## -->
<?php include('./assets/inc/nav.inc.php'); ?>

  <div id="arbor">
  <div id="nav">
    <a class="back" href="#">&laquo;Back</a>
    <p>Learn more about Raw Designs</p>
  </div>
  
  <canvas id="viewport">
    <h2>Download a better web browser to view this content</h2>
  </canvas>

  <div id="docs">
    <div id="introduction">
      <div role="main" id="container" class="container">
        <div class="row">
          <div class="span12">
            <div class="hero-unit">
              <h1>Web &amp; New Media</h1>
              <h2>Development + Design</h2>
            </div><!-- .hero-unit -->
          </div><!-- .span12 -->
        </div><!-- .row -->
        <hr />
        <div class="row">
          <div class="span5">
            <h3>Welcome</h3>
            <p>My name is Rob, and I am <a id="tool" href="#" title="Rob Abby Web Designs" onClick="return false">Raw Designs</a>.  Based in the northern Chicaoland area, I specialize in building &amp; developing websites that capture and engage your audience.  I am focused on helping small to medium sized businesses achieve their online dreams.</p>
          </div><!-- .span6 -->
          <div class="span5 offset2 textalign-right">
            <h3>So...what?</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          </div><!-- .span6 -->
        </div><!-- .row -->
        <hr />
        <br />
        <div class="row">
          <div class="span12">
              <h3>Headine</h3>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          </div><!-- .span12 -->
        </div><!-- .row -->
        <hr />
      </div><!-- #container -->
    </div><!-- #introduction -->
    
    <div id="reference">
      <div role="main" id="container" class="container">
        <div class="row">
          <div class="span12">
            <div class="hero-unit">
              <h1>Web &amp; New Media</h1>
              <h2>Development + Design</h2>
            </div><!-- .hero-unit -->
          </div><!-- .span12 -->
        </div><!-- .row -->
        <hr />
        <div class="row">
          <div class="span5">
            <h3>Welcome</h3>
            <p>My name is Rob, and I am <a id="tool" href="#" title="Rob Abby Web Designs" onClick="return false">Raw Designs</a>.  Based in the northern Chicaoland area, I specialize in building &amp; developing websites that capture and engage your audience.  I am focused on helping small to medium sized businesses achieve their online dreams.</p>
          </div><!-- .span6 -->
          <div class="span5 offset2 textalign-right">
            <h3>So...what?</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          </div><!-- .span6 -->
        </div><!-- .row -->
        <hr />
        <br />
        <div class="row">
          <div class="span12">
              <h3>Headine</h3>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          </div><!-- .span12 -->
        </div><!-- .row -->
        <hr />
      </div><!-- #container -->
    </div><!-- #reference -->

  </div>

<?php include('./assets/inc/footer.inc.php'); ?>
<!-- run from the minified library file: -->
<script type="text/javascript" src="/assets/js/arbor/lib/arbor.js"></script> 
<script type="text/javascript" src="/assets/js/arbor/lib/arbor-tween.js"></script> 
<script type="text/javascript" src="/assets/js/arbor/lib/arbor-graphics.js"></script>
<script type="text/javascript" src="/assets/js/arbor/main.js"></script>
<script type="text/javascript" src="/assets/js/canvas/excanvas.js"></script>
<script type="text/javascript" src="/assets/js/queryloader2.js"></script>
<script type='text/javascript'>
  $(document).ready(function () {
      //$("#viewport").queryLoader2({
        percentage: true,
        backgroundColor: '#121212',
        barHeight: 5,
        barColor: '#FFF',
        completeAnimation: 'fade'
      });
  });
</script>
</body>
</html>
<?php
  } catch (exception $e) {
    ob_end_clean();
    header('Location: error.php');
  }
  ob_end_flush();
?>