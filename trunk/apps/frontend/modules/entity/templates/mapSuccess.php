<?php slot('body tag'); ?>
  <body id="entity-map-page">
<?php end_slot();?>

<?php slot('breadcrumb') ?>
<ul>
  <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
  <li><a href="<?php echo url_for('@entity_list?entity_type='.$entity['EntityType']['url_slug'])?>"><?php echo htmlspecialchars(ucfirst($entity['EntityType']['url_slug']), ENT_COMPAT, 'utf-8') ?></a></li>
  <li><a href="<?php echo url_for('@entity_view?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>"><?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?></a></li>
  <li class="selected"><a href="<?php echo url_for('@entity_map?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>">Map</a></li>
</ul>
<?php end_slot();?>
    
  <!--#MAIN CONTENT-->   
  <div id="content" class="span-12">
      <div class="span-12">
          
		  	<!--MAIN HEADING-->
			<div class="span-12" id="block-044">
				<div class="top left-offset-white offset-text">Top</div>
				<div class="inner">
					<h2 class="sIFR-c4"><?php echo htmlspecialchars($entity['name'], ENT_COMPAT, 'utf-8') ?></h2>
				</div>
				<div class="cubt offset-text">Box Bottom</div>
				<div class="bottom left-offset-white offset-text">Bottom</div>
			</div>
			<!--#block-044-->	
				
			<script type="text/javascript">
				var flashvars = {};
					flashvars.xml = <?php print json_encode($mapUrl); ?>;
				var params = {};
					params.allowscriptaccess = "always";
				var attributes = {};
				swfobject.embedSWF(<?php echo json_encode(foaf_image('/static/swf/map.swf')) ?>, "map-of-power", "940", "750", "10.0.0", <?php echo json_encode(foaf_image('/static/swf/expressInstall.swf')) ?>, flashvars, params, attributes);
			</script>
				
			<div class="span-12 block-012">
				<div class="flash-map-outer">
					<div id="map-of-power"><p>Sorry, we cannot show you the map at the moment. Please check you have JavaScript enabled and the Flash Player plug-in installed. <br>
		  			You can download Flash Player here <a href="http://get.adobe.com/flashplayer/">Adobe Flash Player Download</a></p></div>
				</div>
			</div>
			
			
      </div>
  </div><!--#END OF MAIN CONTENT--> 
