<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript" charset="utf-8">
      google.load("jquery", "1.3");
      google.load("jqueryui", "1.7");
    </script>
  
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
  <body>
    <div class="container" style="margin-bottom: 1.5em;">
      <div class="span-24 last" style="border-bottom: 3px solid black;background: #ffe">
        <h2 style="margin:0"><a href="<?php echo url_for('homepage') ?>">C4 FOAF/Map of Power</a></h2>
          <p><span class="quiet">Database Administration</span></p>
      </div>
      <div class="span-4"><strong>Shortcuts: </strong></div>
      <div class="span-4">
        <a href="<?php echo url_for('entity_new') ?>">New Entity</a>
      </div>
      <div class="span-4">
        <a href="<?php echo url_for('fact_new') ?>">New Fact</a>
      </div>
    </div>
    
    <?php echo $sf_content ?>
  </body>
</html>
