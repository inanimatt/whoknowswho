<?php slot('body tag'); ?>
  <body id="home-page">
<?php end_slot();?>
    
    <!--#MAIN CONTENT-->   
    <div id="content" class="span-12">
        
        <!--intro copy-->
        <div class="span-12 block-026" id="iefix-026">
            <div class="span-8">
                <div class="left-side">
                    <p><strong>WKW</strong> intro text lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <?php print link_to('About the site', '@about') ?>.</p>
                </div>
            </div>
            <div class="span-4 last">
                <div class="right-side">
                    <p>Link to contact form, <?php print link_to('contact us', '@contact') ?>.</p>
                </div>
            </div>
        </div>
        
        
        <div class="span-12 columns">
            <!--LEFT COLUMN START-->
            <div class="span-8">
                                
              <!--main image area-->
              <div class="span-8 block-027" id="iefix-027">
                <?php echo $content['feature_html'] ?>
              </div><!--block-027-->
                
              <div id="block-030" class="span-8 left-offset-white">
                <?php echo $content['feature_copy_intro'] ?>
                <p class="read-more"><a href="#">Read More</a></p>
                
                <div class="hidden">
          <?php echo $content['feature_copy_extended'] ?>
                </div>
                        
              </div>
                
                <div class="b-out box-left-out-016">
                    <div class="b-in box-left-in-016">Box footer</div>
                </div>
                
                <div class="span-8">
                    <!--COLUMN LEFT SIDE-->
                    <div class="span-4">
                        
                        <!--Story-->
                      <?php $s = $content['Story1']; ?>
                        <div class="block-028">
                            <div class="header"></div>
                                <div class="pos">
                                    <div class="content">
                                    <?php if ($content['story1_image_url']): ?>
                                        <div class="image">
                                            <a href="<?php echo $s->getUrl() ?>"><img src="<?php print htmlspecialchars($content['story1_image_url']) ?>" width="264" alt="<?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?>"></a>
                                        </div>
                                                    <?php endif; ?>

                                        <h5>
                                            <a href="<?php echo $s->getUrl() ?>"><?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?></a>
                                        </h5> 
                                        <div class="clearfix">                                  
                                            <ul>
                                              <?php echo rating_stars($s->getRating()->getAverageVote()) ?>
                                            </ul>
                                             <p class="rating"><?php echo $s->getRating()->getTotalVotes() ?> ratings</p>
                                        </div>
                                       
                                      <p><?php echo $s->getTeaser() ?></p>
                                      <p class="read-more"><a href="<?php echo $s->getUrl() ?>">Read more...</a></p>
                                    </div>
                                </div>
                            <div class="footer offset-text">Box footer</div>
                        </div><!--block-028-->
                        
                        <?php $s = $content['Story3']; ?>
                        <div class="block-028 bottom">
                            <div class="header"></div>
                            <div class="pos">
                                <div class="content">
                                  <?php if ($content['story3_image_url']): ?>
                                    <div class="image">
                                        <a href="<?php echo $s->getUrl() ?>"><img src="<?php print htmlspecialchars($content['story3_image_url']) ?>" width="264" alt="<?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?>"></a>
                                    </div>
                                                <?php endif; ?>

                                    <h5 class="blue">
                                        <a href="<?php echo $s->getUrl() ?>"><?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?></a>
                                    </h5>   
                                    <div class="clearfix">                              
                                    <ul>
                                      <?php echo rating_stars($s->getRating()->getAverageVote()) ?>
                                    </ul>
                                    <p class="rating"><?php echo $s->getRating()->getTotalVotes() ?> ratings</p>
                                    </div> 
                                    <p><?php echo $s->getTeaser() ?></p>
                                    <p class="read-more"><a href="<?php echo $s->getUrl() ?>">Read more...</a></p>
                                </div>
                            </div>
                            <div class="footer offset-text">Box footer</div>
                        </div><!--block-028-->
                        
                    </div>
                    
                    
                    <!--story column right-side -->
                    <div class="span-4 last">
                        <!--block-029-->
                        <?php $s = $content['Story2']; ?>
                        <div class="block-029">
                            <div class="content">
                            <?php if ($content['story2_image_url']): ?>
                                <div class="image">
                                    <a href="<?php echo $s->getUrl() ?>"><img src="<?php print htmlspecialchars($content['story2_image_url']) ?>" width="264" alt="<?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?>"></a>
                                </div>
                                            <?php endif; ?>

                                <h5 class="blue">
                                  <a href="<?php echo $s->getUrl() ?>"><?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?></a>
                                </h5>   
                                  <div class="clearfix">                              
                                  <ul>
                                    <?php echo rating_stars($s->getRating()->getAverageVote()) ?>
                                    </ul>
                                    <p class="rating"><?php echo $s->getRating()->getTotalVotes() ?> ratings</p>
                                  </div> 
                                  <p><?php echo $s->getTeaser() ?></p>
                                  <p class="read-more"><a href="<?php echo $s->getUrl() ?>">Read more...</a></p>
                            </div>
                            <div class="footer offset-text">Box footer</div>
                      </div><!--block-029-->
                        
                        <!--block-029-->
                        <div class="block-029 bottom">
                      <?php $s = $content['Story4']; ?>
                            <div class="content">
                            <?php if ($content['story4_image_url']): ?>
                                <div class="image">
                                    <a href="<?php echo $s->getUrl() ?>"><img src="<?php print htmlspecialchars($content['story4_image_url']) ?>" width="264" alt="<?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?>"></a>
                                </div>
                            <?php endif ?>
                                <h5 class="blue">
                                    <a href="<?php echo $s->getUrl() ?>"><?php echo htmlspecialchars($s->getTitle(), ENT_COMPAT, 'utf-8') ?></a>
                                    </h5>   
                                    <div class="clearfix">                              
                                    <ul>
                                      <?php echo rating_stars($s->getRating()->getAverageVote()) ?>
                                    </ul>
                                    <p class="rating"><?php echo $s->getRating()->getTotalVotes() ?> ratings</p>
                                    </div> 
                                    <p><?php echo $s->getTeaser() ?></p>
                                    <p class="read-more"><a href="<?php echo $s->getUrl() ?>">Read more...</a></p>
                            </div>
                            <div class="footer offset-text">Box footer</div>
                      </div><!--block-029-->
                        
                        
                    </div>
                </div>          
          </div>
            
            <!--RIGHT COLUMN START-->
            <div class="span-4 last">
                <div class="span-4 block-033">
                <?php echo $content['callout_html']; ?>
                    <div class="footer offset-text">Footer</div>
                </div>
                
            
                <div class="span-4 block-013">
                                       
                        <!--MOST SEARCHED-->
                        <div class="span-4 block-031">
                            <h5 class="sIFR-c4">The most viewed</h5>
                            <p><a href="<?php echo url_for('@entity_list?entity_type=people')?>">View all people</a></p>
                        </div><!--block-031-->
                        
                        <div class="span-4 block-032">
                            <div class="span-4 header offset-text">Header</div>
                            <div class="span-4 content">
                                <div class="span-4 pos">
                                    <ul>
                                      <?php end($most_viewed); $end = key($most_viewed); foreach ($most_viewed as $entity_data): $e = $entity_data['entity']; ?>
                                      <li class="<?php 
                                          echo 0 == key($most_viewed) ? 'first ' : ''; 
                                          echo $end == key($most_viewed) ? 'last ' : '' 
                                          ?>clearfix">
                                          <img src="<?php echo foaf_image($e['PhotoUrlSmall']) ?>" alt="<?php echo htmlspecialchars($e['name'], ENT_COMPAT, 'utf-8') ?>">
                                          <div class="info">
                                            <a href="<?php echo htmlspecialchars($e->getUrl(), ENT_COMPAT, 'utf-8') ?>" class="name"><?php echo htmlspecialchars($e['name'], ENT_COMPAT, 'utf-8') ?></a>
                                              <p><?php echo htmlspecialchars($e['subtitle'], ENT_COMPAT, 'utf-8') ?>&nbsp;</p>
                                          </div>
                                          <div class="connections"><a href="<?php echo htmlspecialchars($e->getMapUrl(), ENT_COMPAT, 'utf-8') ?>"><?php echo htmlspecialchars($entity_data['connections'], ENT_COMPAT, 'utf-8') ?></a>Connections</div>
                                    </li>
                                      <?php endforeach ?>
                                    </ul>
                                </div><!--pos-->
                            </div><!--content-->
                            <div class="span-4 footer"></div>
                        </div> <!--block-032-->

              </div>
            </div>
        </div><!--columns-->
    </div><!--#content-->
</div>  
