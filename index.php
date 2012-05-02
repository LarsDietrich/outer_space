<?php 
  $path2root = "";
  ob_start();
  try {
  include('./assets/inc/title.inc.php'); 
  include('./assets/inc/user_agent.php');
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="/assets/css/style_ie.css" />
<![endif]-->
<head>
  <?php include('./assets/inc/head.inc.php'); ?>
  <link rel="stylesheet" href="/assets/css/queryLoader.css" type="text/css" />
  <noscript>
    <style>
    .step {
      width: 100%;
      position: relative;
    }
    .step:not(.active) {
      opacity: 1;
      filter: alpha(opacity=99);
      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(opacity=99)";
    }
    .step:not(.active) a.jms-link{
      opacity: 1;
      margin-top: 40px;
    }
    </style>
  </noscript>
  <style>
  </style>
</head>
<body id="home">
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 9]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

  <div class="modal fade" id="contact">
    <div class="modal-header">
      <a class="close" data-dismiss="modal">×</a>
      <h3>Contact</h3>
    </div>
    <div class="modal-body">
      <form>
        <label>Name</label>
        <input type="text" class="span3" placeholder="Name">
        <label>Email</label>
        <input type="text" class="span3" placeholder="Email">
      </form>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-inverse">Submit</button>
      <a href="#" data-dismiss="modal" class="btn">Cancel</a>
    </div>
  </div>

<!-- ## HEADER & NAV ## --
<?php include('./assets/inc/nav.inc.php'); ?>
-->

<div id="container" class="container">
  
  <!-- ##### SOLAR SYSTEM ##### -->
  <div id="star" class="star-1"></div>
  <div id="star" class="star-2"></div>
  <div id="star" class="star-3"></div>
  <div id="star" class="star-4"></div>
  <div id="star" class="star-5"></div>
  <div id="moon" class="moon"></div>
  <div id="planet" class="planet"></div>
  <div id="planet2" class="planet2"></div>
  <!-- ##### SOLAR SYSTEM ##### -->
  
  <section id="jms-slideshow" class="jms-slideshow">
    <div class="step" data-color="color-1">
      <div class="jms-content">
        <h3>Welcome</h3>
        <p>My name is Rob. I build interactive, web-based experiences that are out of this world.</p>
        <!--<a class="jms-link" href="#">Read more</a>-->
      </div>
      <!--<img class="inset" src="images/rd_logo.png" width="300" height="300" />-->
      <img src="/images/earth_icon.png" width="300" height="300" />
    </div>
    <div class="step" data-color="color-2" data-y="500" data-scale="0.4" data-rotate-x="30">
      <div class="jms-content">
        <h3>Standards are everything</h3>
        <p>All of the websites I build are standards compliant, ensured to work on all modern web browsers <br /> (and devices).</p>
        <a class="jms-link" href="#">Read more</a>
      </div>
      <img src="/images/captain_icon.png" />
    </div>
    <div class="step" data-color="color-3" data-x="2000" data-z="3000" data-rotate="170">
      <div class="jms-content">
        <h3>Think Mobile</h3>
        <p>My products work on iPhone, iPad, Android, Windows Phone, Blackberry, Nokia, WebOS, and more...</p>
        <a class="jms-link" href="#">Read more</a>
      </div>
      <img src="images/ipad_happy.png" />
    </div>
    <div class="step" data-color="color-4" data-x="3000">
      <div class="jms-content">
        <h3>Think Modern</h3>
        <p>Now, more than ever, it is crucial for web-goers <br /> to embrace more advanced (and secure) ways <br /> of browsing the web.</p>
        <a class="jms-link" href="#">Read more</a>
      </div>
      <img src="images/browsers.png" />
    </div>
    <div class="step" data-color="color-5" data-x="4500" data-z="1000" data-rotate-y="45">
      <div class="jms-content">
        <h3>Did you know that...</h3>
        <p>Thou that art now the world's fresh ornament and only herald to the gaudy spring</p>
        <a class="jms-link" href="#">Read more</a>
      </div>
      <img class="inset2" src="images/calvin_sandbox.jpg" />
    </div>
  </section>
</div>

<?php include('./assets/inc/footer.inc.php'); ?>

<script type="text/javascript" src="/assets/js/jmpress.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.jmslideshow.js"></script>
<script type="text/javascript" src="js/modernizr.custom.48780.js"></script>
<script type="text/javascript">
  $(function() {
    $( '#jms-slideshow' ).jmslideshow();
  });
</script>
<script type="text/javascript" src="/assets/js/queryloader2.js"></script>
<script type='text/javascript'>
  $(document).ready(function () {
      $("body").queryLoader2({
        percentage: true,
        backgroundColor: '#121212',
        barHeight: 5,
        barColor: '#FFF',
        completeAnimation: 'grow'
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