<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
  
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <?php include_stylesheets(); ?>
  <?php include_javascripts(); ?>

  <!--[if lte IE 8]>
  		<link rel="stylesheet" href="<?php echo foaf_image('/static/css/ie.css') ?>" type="text/css" media="screen" charset="utf-8">
  <![endif]-->
  <!--[if IE 6]>
  		<link rel="stylesheet" href="<?php echo foaf_image('/static/css/ie6.css') ?>" type="text/css" media="screen" charset="utf-8">
		<script type="text/javascript" src="<?php echo foaf_image('/static/js/unitpngfix.js') ?>"></script>
  <![endif]-->
  <!--[if IE 7]>
  		<link rel="stylesheet" href="<?php echo foaf_image('/static/css/ie7.css') ?>" type="text/css" media="screen" charset="utf-8">
  <![endif]-->
  <!--[if IE 8]>
  		<link rel="stylesheet" href="<?php echo foaf_image('/static/css/ie8.css') ?>" type="text/css" media="screen" charset="utf-8">
  <![endif]-->
</head>

<?php if (has_slot('body tag')): include_slot('body tag'); else: ?>
<body>
<?php endif; ?>
<div class="container">	
	<div id="header" class="span-12">

       
       <!--Breadcrumb and search box-->     
       <div class="span-12 outer">
            <div class="span-12 inner">
         		<div class="span-12 main">
					<div class="home-link"><a href="<?php echo url_for('@homepage') ?>"><span class="offset-text">Who Knows Who Home</span></a></div>
                    <ul>
                        <li><?php echo link_to('About','@about') ?></li>
                        <li class="last"><?php echo link_to('Contact', '@contact') ?></li>
                    </ul>
            	</div>
            
                <div class="span-12 submain">
                    <div class="span-8 breadcrumb">
                        <p>You are here</p>
                        <?php if (has_slot('breadcrumb')): ?>
                          <?php include_slot('breadcrumb'); ?>
                        <?php else: ?>
                          <ul>
                              <li class="selected"><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
                          </ul>
                        <?php endif ?>
                  </div>
                    <div class="span-4 last search">
                        <form action="<?php echo url_for('@search_results') ?>" method="get">
							<div>
								<label for="searchtext">Search</label>
								<input type="text" name="q" id="searchtext" value="Search">
								
								<label for="gobutton">Go</label>
								<input type="submit"  name="go" id="gobutton" value="Go">
							</div>                    
                        </form>
                    </div>	 
                </div><!--span-12 submain-->
            </div>
       </div><!--span-12 outer-->
	</div><!--#header-->
        
  <?php echo $sf_content ?>

	<div class="span-12 footer-spacer offset-text">Footer Spacer</div>


</div>
	
 
</body>
</html>
