<?php slot('body tag'); ?>
  <body id="entity-page">
<?php end_slot();?>

<?php slot('breadcrumb') ?>
<ul>
  <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
  <li><a href="<?php echo url_for('@entity_list?entity_type='.$entity['EntityType']['url_slug'])?>"><?php echo htmlspecialchars(ucfirst($entity['EntityType']['url_slug']), ENT_COMPAT, 'utf-8') ?></a></li>
  <li class="selected"><a href="<?php echo url_for('@entity_view?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>"><?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?></a></li>

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
        flashvars.xml = "<?php print url_for('@entity_map?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'].'&format=xml')  ?>";
        var params = {};
          params.allowscriptaccess = "always";
        var attributes = {};
        swfobject.embedSWF("<?php echo foaf_image('/static/swf/mapsmall.swf') ?>", "map-of-power", "940", "325", "10.0.0", "<?php echo foaf_image('/static/swf/expressInstall.swf') ?>", flashvars, params, attributes);
      </script>
        
      <div class="span-12 block-012">
        <div class="flash-map-outer">
          <div id="map-of-power"><p>Sorry, we cannot show you the map at the moment. Please check you have JavaScript enabled and the Flash Player plug-in installed. <br>
		  			You can download Flash Player here <a href="http://get.adobe.com/flashplayer/">Adobe Flash Player Download</a></p></div>
        </div>
      </div>  
                 
          
            <div class="span-12">
              <div class="b-out box-right-013"></div>
            </div>

            <!--content in columns-->
            <div class="span-12 columns">
                <!--LEFT COLUMN START-->
                <div class="span-8">
                    
                    
                    
                    <!--entity info-->
                    <div class="span-8 block-017 left-offset-white">
						<!--licence info-->
                    	<p class="attrition">
                    	  <?php if ($entity['photo_caption'] != 'Licence to be determined - open source'): ?>
							Image: <?php echo htmlspecialchars($entity['photo_caption'], ENT_COMPAT, 'utf-8') ?>
							<a href="<?php echo htmlspecialchars($entity['photo_licence'], ENT_COMPAT, 'utf-8') ?>"><?php echo htmlspecialchars($entity['photo_licence'], ENT_COMPAT, 'utf-8') ?></a>
						  <?php endif; ?>                    		
						</p>
                        <div class="pos">
                            <p class="heading">Position</p>
                            <p><?php echo htmlspecialchars($entity['subtitle'], ENT_COMPAT, 'utf-8') ?></p>
                            
                            <?php if (count($entity['Aliases'])): ?>
                              <p class="heading">Also known as</p>
                              <p>
                                <?php foreach ($entity['Aliases'] as $a): ?>
                                  <?php echo htmlspecialchars($a['name'], ENT_COMPAT, 'utf-8') ?><br>
                                <?php endforeach ?>
                              </p>
                              
                            <?php endif ?>
                        </div>
                        <div class="biog">
                            <p class="heading">Biography</p>
                          <?php echo htmlspecialchars($entity['description'], ENT_COMPAT, 'utf-8') ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="divider clearfix">Dotted divider</div>
                    </div><!--block-017-->
                    
                    <!--connections header-->
                    <div class="span-8 block-018">
                        <h4>Connections</h4>
                        <p class="blue"><?php echo htmlspecialchars($connections['count']['total'], ENT_COMPAT, 'utf-8') ?> connections</p>
                        <a href="<?php echo url_for('@suggest_connection') ?>">Suggest a connection</a>
                    </div><!--block-018-->
                    
                    
                   <!--connections-->
                   
                    <div class="span-8 block-019 left-offset-white">
                        <div class="span-8 divider"><?php echo htmlspecialchars($connections['count']['personal'], ENT_COMPAT, 'utf-8') ?> personal connections  <a href="<?php echo $entity->getConnectionsUrl() ?>">see all</a></div>
                        <div class="span-8 clearfix">
                            <?php $i = 0; ?>
                            <?php foreach ($connections['personal'] as $pc): $i++; ?>
                              <div class="connection<?php if ($i % 4 == 0) { print ' last';} ?>">
                                  <a href="<?php echo url_for('@entity_view?entity_type='.$pc['EntityType']['url_slug'].'&id='.$pc['slug']) ?>"><img src="<?php echo foaf_image($pc['photo_url'], true) ?>"  alt="<?php echo htmlspecialchars($pc['name'], ENT_COMPAT, 'utf-8') ?>"></a> 
                                  <a href="<?php echo url_for('@entity_view?entity_type='.$pc['EntityType']['url_slug'].'&id='.$pc['slug']) ?>"><?php echo htmlspecialchars($pc['name'], ENT_COMPAT, 'utf-8') ?></a>
                                  <p><?php echo htmlspecialchars($pc['subtitle'], ENT_COMPAT, 'utf-8') ?></p>
                              </div>
                            <?php endforeach ?> 
                        </div>
                        
                        <div class="span-8 divider"><?php echo htmlspecialchars($connections['count']['other'], ENT_COMPAT, 'utf-8') ?> group connections <a href="<?php echo $entity->getConnectionsUrl() ?>">see all</a></div>
                        <div class="span-8 clearfix">
                                <?php $i = 0 ?>
                                <?php if (5 == $i) {break;} ?>
                            <?php foreach ($connections['other'] as $oc): ?>
                              <?php $i++?>
                              <div class="connection<?php if ($i % 4 == 0) { print ' last';} ?>"> 
                                  <a href="<?php echo url_for('@entity_view?entity_type='.$oc['EntityType']['url_slug'].'&id='.$oc['slug']) ?>"><img src="<?php echo foaf_image($oc['photo_url'], true) ?>"  alt="<?php echo htmlspecialchars($oc['name'], ENT_COMPAT, 'utf-8') ?>"></a> 
                                  <a href="<?php echo url_for('@entity_view?entity_type='.$oc['EntityType']['url_slug'].'&id='.$oc['slug']) ?>"><?php echo htmlspecialchars($oc['name'], ENT_COMPAT, 'utf-8') ?></a>
                                  <p><?php echo htmlspecialchars($connections['other'][0]['subtitle'], ENT_COMPAT, 'utf-8') ?></p>
                              </div>
                            <?php endforeach ?> 
                        </div>
                    </div>
                    <!--block-019-->
                    
                    
                        <div class="b-out box-left-out-014">
                            <div class="b-in box-left-in-014">Box footer</div>
                        </div>
                    
                    <!--Interestingly enough-->
                    <div class="span-8 left-offset-white" id="block-020">
                      <h4>Interestingly enough...</h4>
                      <?php if ($facts->count() == 0): ?>
                        <p>Sorry, no facts have yet been added. <a href="<?php echo url_for('@suggest_fact') ?>">Why not suggest one?</a></p>
                      <?php else: ?>
                        <?php foreach ($facts as $fact): ?>
                          <p><?php print htmlspecialchars($fact->getEntity(), ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['title'], ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['RelatedEntity']['name'], ENT_COMPAT, 'utf-8') ?> 
                            <span class="sources">source - <?php foreach ($fact['Sources'] as $source) { print link_to(htmlspecialchars($source['title'], ENT_COMPAT, 'utf-8'), htmlspecialchars($source['url'], ENT_COMPAT, 'utf-8')). '&nbsp;&nbsp;&nbsp;'; } ?></span></p>
                        <?php endforeach ?>
                        <div class="more-facts"></div>
                        <?php if ($facts->count() == 10): ?>
                          <p class="see-all"><a href="<?php echo url_for('@entity_interesting_facts?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug']) ?>">See all</a></p>
                        <?php endif ?>
                      <?php endif ?>
                    </div><!--block-019-->
                    
                    
                    <!-- RUSS is altering the footer of the interestingly enough box here so that entities who are not people don't have the boxes -->
                    <?php if ($entity->getEntityType() != 'Person'): ?>
                        <div class="b-out box-left-out-016"> 
                             no facts
                            <div class="b-in box-left-in-016">Box footer</div> 
                        </div> 
                    <?php else: ?>
                        <div class="b-out box-left-out-014">
                            <div class="b-in box-left-in-014">Box footer</div>
                        </div>
                        
                        <div class="b-out box-left-out-015">
                            <div class="b-in box-left-in-015">Box footer</div>
                        </div>
                    <?php endif ?>
                    
                    
                    <div class="span-8 clearfix block-021">
                        <div class="left">
                            <!--education-->
                            <?php if ($entity->getEntityType() == 'Person'): ?>
                              <div class="block-022">
                                <div class="pos">
                                     <div class="content">
                                        <h4>Education</h4>
                                        <ul>
                                          <?php if ($education_facts->count() == 0): ?>
                                            <li>
                                              Do you know any facts about this person's education? Did you go to school or college with them? Please <a href="<?php echo url_for('@suggest_fact') ?>">let us know</a> .
                                            </li>
                                          <?php else: ?>
                                            <?php foreach($education_facts as $eduf): ?>
                                              <li><?php print htmlspecialchars($eduf['description'], ENT_COMPAT, 'utf-8') ?>
                                                <span class="sources">source - <?php foreach ($eduf['Sources'] as $source) { print link_to(htmlspecialchars($source['title'], ENT_COMPAT, 'utf-8'), htmlspecialchars($source['url'], ENT_COMPAT, 'utf-8')). '&nbsp;&nbsp;&nbsp;'; } ?></span>
                                              </li>
                                            <?php endforeach ?>
                                          <?php endif ?>
                                        </ul>   
                                     </div>
                                </div>
                                <div class="footer offset-text">Box footer</div>
                              </div><!--block-022-->
                            <?php endif ?>
                          
                           <!--on the web--> 
           
           
                           <?php if ($links->count() > 0): ?>

                           
                           <?php if ($entity->getEntityType() != 'Person'): ?>
                            <div class="block-023">
                            	<div class="lonely"></div>
                            <?php else: ?>
                            <div class="block-023">
                                <div class="header"></div>
                            <?php endif ?>
                            
                            
                            	
                            
                                
                                    <div class="pos">
                                        <div class="content">
                                            <h4><?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?> on the web</h4>
                                            <ul>
                                              <?php foreach ($links as $link): ?>
                                                <li class="clearfix">
                                                  <a href="<?php print htmlspecialchars($link['url'], ENT_COMPAT, 'utf-8') ?>"><?php print htmlspecialchars($link['title'], ENT_COMPAT, 'utf-8') ?></a>
                                                  <!-- <img src="<?php echo foaf_image('/static/images/site/on_web_icon_wikipedia.gif') ?>" width="18" height="15" alt="wiki"> -->
                                                </li>
                                              <?php endforeach ?>
                                            </ul>
                                        </div>
                                    </div>
                                <div class="footer offset-text">Box footer</div>
                          </div><!--block-023-->
                        
                        <?php endif ?>
                        
                        
                        </div><!--left-->
                        <div class="right">
                          <?php if ($entity->getEntityType() == 'Person'): ?>
                            <div class="block-024">
                                <div class="pos">
                                    <div class="content">
                                        <h4>CV</h4>
                                        <ul>
                                          <?php if ($employment_facts->count() == 0): ?>
                                            <li>
                                              Do you know any facts about this person's CV? Please <a href="<?php echo url_for('@suggest_fact') ?>">let us know</a> .
                                            </li>
                                          <?php else: ?>
                                            <?php foreach($employment_facts as $empf): ?>
                                              <li>
                                                <?php if ($empf['start'] || $empf['end']): ?>
                                                  <span class="date">
                                                    <?php 
                                                      echo $empf['start'] ? date_create($empf['start'])->format('Y') : '&nbsp;';
                                                      echo ($empf['start'] || $empf['end']) ? ' - ' : '';
                                                      echo $empf['end']   ? date_create($empf['end'])->format('y'): ''; 
                                                    ?>&nbsp;
                                                  </span>
                                                <?php endif ?>
											
                                                <?php print htmlspecialchars($empf['description'], ENT_COMPAT, 'utf-8') ?>
                                                <span class="sources">source - <?php foreach ($empf['Sources'] as $source) { print link_to(htmlspecialchars($source['title'], ENT_COMPAT, 'utf-8'), htmlspecialchars($source['url'], ENT_COMPAT, 'utf-8')). '&nbsp;&nbsp;&nbsp;'; } ?></span>
                                              </li>
                                            <?php endforeach ?>
                                          <?php endif ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="footer offset-text">Box footer</div>
                            </div>
                          <?php endif ?>  
                        </div>
                    </div><!--block-021-->

                </div>
                
                <!--RIGHT COLUMN START-->
                <div class="span-4 last" style="background:#0C3">
                    <div class="span-4 block-013">
                      <?php if ($stories->count() != 0): ?>                     
                        <div class="span-4 block-015">
                            <h4 class="sIFR-c4">Stories</h4>
                            <a href="<?php echo url_for('@entity_story_list?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug']) ?>">View all stories (<?php print $stories->count() ?>)</a>
                        </div><!--block-015-->
                       
                        <!--first story item-->
                        <div class="span-4 block-014 first-story<?php if ($stories->count() <= 1) { print " single-story"; }?>">
                            <div class="span-4 header"></div>
                            <div class="span-4 content">
                                <div class="span-4 pos">
                                    <h5 class="blue"><a href="<?php echo $stories[0]->getEntityContextUrl($entity) ?>"><?php echo htmlspecialchars($stories[0]['title'], ENT_COMPAT, 'utf-8') ?></a></h5>                                   
                                    <ul>
                                      <?php echo rating_stars($stories[0]->getRating()->getAverageVote()) ?>
                                    </ul>
                                    <p class="rating"><?php echo htmlspecialchars($stories[0]->getRating()->getTotalVotes(), ENT_COMPAT, 'utf-8') ?> ratings</p>
                                    <p class="heading"><?php echo htmlspecialchars($stories[0]->getSubtitle(), ENT_COMPAT, 'utf-8') ?></p>
                                    <p><?php echo htmlspecialchars($stories[0]->getTeaser(), ENT_COMPAT, 'utf-8') ?></p>
                                    <p class="read-more"><a href="<?php echo $stories[0]->getEntityContextUrl($entity) ?>">Read more...</a></p>
                                </div>
                            </div>
                            <div class="span-4 footer"></div>
                        </div> <!--block-014-->
                        
                        <?php if (isset($stories[1])): $s = $stories[1];  ?>
                        <div class="span-4 block-014<?php if (!isset($stories[2])): echo ' last-story'; endif; ?>">
                            <div class="span-4 header"></div>
                            <div class="span-4 content">
                                <div class="span-4 pos">                                 
                                    <h5 class="blue">
                                        <a href="<?php echo $s->getEntityContextUrl($entity) ?>"><?php echo htmlspecialchars($s['title'], ENT_COMPAT, 'utf-8') ?></a>
                                    </h5>
                                    <ul>
                                      <?php echo rating_stars($s->getRating()->getAverageVote()) ?>
                                    </ul>
                                    <p class="rating"><?php echo htmlspecialchars($s->getRating()->getTotalVotes(), ENT_COMPAT, 'utf-8') ?> ratings</p>
                                    <p class="heading"><?php echo htmlspecialchars($s->getSubtitle(), ENT_COMPAT, 'utf-8') ?></p>
                                    <p><?php echo htmlspecialchars($s->getTeaser(), ENT_COMPAT, 'utf-8') ?></p>
                                    <p class="read-more"><a href="<?php echo $s->getEntityContextUrl($entity) ?>">Read more...</a></p>

                                </div>
                              </div>
                            <div class="span-4 footer"></div>
                        </div> <!--block-014-->
                        <?php endif ?>


                        <?php if (isset($stories[2])): $s = $stories[2]; ?>
                        <!--last story item-->
                        <div class="span-4 block-014 last-story">
                          <div class="span-4 header"></div>
                            <div class="span-4 content">
                              <div class="span-4 pos">
                                <h5 class="blue"><a href="<?php echo $s->getEntityContextUrl($entity) ?>"><?php echo htmlspecialchars($s['title'], ENT_COMPAT, 'utf-8') ?></a></h5>                                   

                                    <ul>
                                      <?php echo rating_stars($s->getRating()->getAverageVote()) ?>
                                    </ul>
                                    <p class="rating"><?php echo htmlspecialchars($s->getRating()->getTotalVotes(), ENT_COMPAT, 'utf-8') ?> ratings</p>
                                    <p class="heading"><?php echo htmlspecialchars($s->getSubtitle(), ENT_COMPAT, 'utf-8') ?></p>
                                    <p><?php echo htmlspecialchars($s->getTeaser(), ENT_COMPAT, 'utf-8') ?></p>
                                    <p class="read-more"><a href="<?php echo $s->getEntityContextUrl($entity) ?>">Read more...</a></p>
                                </div>
                              </div>
                            <div class="span-4 footer"></div>
                        </div> <!--block-014-->
                        <?php endif; ?>

                        
                        
<?php endif; ?>
                        
                         <div class="span-4 block-016">
                            <div class="span-4 header"></div>
                            <div class="span-4 content">
                                <div class="span-4 pos">
                                    <a href="<?php print url_for('@suggest') ?>">Suggest a story</a>
									<p>If you have a suggestion for a story to show Who Knows Who, we want to hear from you</p>
									<a href="<?php print url_for('@report') ?>">Report a mistake</a>
									<p>If you spot a mistake or an editorial error on this site, please let us know by emailing us.</p>
                                </div>
                            </div>
                            <div class="span-4 footer"></div>
                        </div> <!--block-014-->
  
                    </div><!--block-013-->
                </div>  
            </div><!--columns--> 
        </div>
        
  </div><!--#content-->
