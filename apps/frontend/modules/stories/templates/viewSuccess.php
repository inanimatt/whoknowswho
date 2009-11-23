<?php slot('body tag'); ?>
  <body id="story-page">
<?php end_slot();?>

<?php
slot('breadcrumb');
?>
<ul>
    <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
    <li><a href="<?php echo url_for('@story_list') ?>">Stories</a></li>
    <li class="selected"><a href="<?php echo url_for('@story_view?id='.$story['id']) ?>"><?php echo htmlspecialchars(shortenTitle($story['title']), ENT_COMPAT, 'utf-8') ?></a></li>
</ul>
<?php end_slot();?>


    <!--#MAIN CONTENT-->   
  <div id="content" class="span-12">
        <div class="span-12">
        	
			<!--MAIN HEADING-->
			<div class="span-12" id="block-044">
				<div class="top left-offset-white offset-text">Top</div>
				<div class="inner">
					<h2 class="sIFR-c4">
						<?php if ($context_entity): ?>
							<a href="<?php echo $context_entity->getUrl() ?>"><?php echo htmlspecialchars(shortenTitle($context_entity->getName()), ENT_COMPAT, 'utf-8') ?></a> stories
						<?php else: ?>
							Stories
						<?php endif ?>
					</h2>
					<p class="stories"><a href="<?php echo url_for('@story_list') ?>" class="stories">View all stories</a></p>
				</div>
				<div class="cubt offset-text">Box Bottom</div>
				<div class="bottom left-offset-white offset-text">Bottom</div>
			</div>
			<!--#block-044-->
			
			<div id="block-045" class="span-12 clearfix">
				<div class="span-12 block-001">
					<div class="span-8 heading">
						<h3 class="sIFR-c4"><?php echo htmlspecialchars($story['title'], ENT_COMPAT, 'utf-8') ?></h3>
						<!--<p>By <a href="#">Channel 4</a> 15th Nov 2009</p>-->
					</div>
					<div class="span-4 last block-002">
						<div class="b-out b-out-002"></div>
						<div class="rating">
							<!--
							<div id="thanks">
								<div>Thank you for rating<br><?php echo htmlspecialchars($story['title'], ENT_COMPAT, 'utf-8') ?></div>	
							</div>
							-->
							<h4>How interesting</h4>
							<div class="rating-holder clearfix">
								<form id="rating-form">
									<label for="star-story-<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>">Rating</label>
									<input id="<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" name="<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" title="user-001" type="hidden" value="<?php echo rating_word($rating);?>">
									<input class="auto-submit-star" type="radio" name="star-story-<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" value="1" title="<?php echo rating_word(1) ?>" <?php if ($rating >= 1): ?>checked="checked"<?php endif ?>/>
									<input class="auto-submit-star" type="radio" name="star-story-<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" value="2" title="<?php echo rating_word(2) ?>" <?php if ($rating >= 2): ?>checked="checked"<?php endif ?>/>
									<input class="auto-submit-star" type="radio" name="star-story-<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" value="3" title="<?php echo rating_word(3) ?>" <?php if ($rating >= 3): ?>checked="checked"<?php endif ?>/>
									<input class="auto-submit-star" type="radio" name="star-story-<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" value="4" title="<?php echo rating_word(4) ?>" <?php if ($rating >= 4): ?>checked="checked"<?php endif ?>/>
									<input class="auto-submit-star" type="radio" name="star-story-<?php echo htmlspecialchars($story['id'], ENT_COMPAT, 'utf-8') ?>" value="5" title="<?php echo rating_word(5) ?>" <?php if ($rating == 5): ?>checked="checked"<?php endif ?>/>
								</form>
								<div id="star-holder">
									<div class="star<?php if ($rating >= 1): ?> selected<?php endif ?>"></div>
									<div class="star<?php if ($rating >= 2): ?> selected<?php endif ?>"></div>
									<div class="star<?php if ($rating >= 3): ?> selected<?php endif ?>"></div>
									<div class="star<?php if ($rating >= 4): ?> selected<?php endif ?>"></div>
									<div class="star<?php if ($rating >= 5): ?> selected<?php endif ?>"></div>
								</div>
							</div>
							<p id="user-rating">
							<?php
							    echo rating_word($rating);
							?>
							</p>
							<p id="yourated"><?php echo $story->getRating()->getTotalVotes() ?> ratings</p>
						</div>
					</div>
					<!--block-002-->
				</div>
				<!--block-001-->
				<!--12 column spacer-->
				<div class="span-12 white-space offset-text">White space</div>
				<div class="b-out b-out-001">
					<div class="b-in b-in-001"></div>
				</div>
				<div class="b-out b-out-001">
					<div class="b-in b-in-003"></div>
				</div>
			</div>
			<!--#block-045-->            
            
           
            <div class="span-12 columns">
								<!--LEFT COLUMN START-->
								<div class="block-042"><a href="#"><span>So who are we talking about?</span></a></div>
								<div class="span-6 left-column">
										<div class="talking-filler"></div>
                    
                    <div class="span-6 block-003">
                      <?php
                        $column = new StoryColumn($story['StoryFacts']);
                        echo $column->render();
                      ?>
					<div class="span-6 showbar-6 offset-text">Bottom Bar</div>
                    </div><!--block-003-->

                    
										<!--box footer-->
                    <div class="b-out b-out-004">
                        <div class="b-in b-in-004">Box footer</div>
                    </div>
                    <!--box spacer-->
                    <div class="b-out b-out-004">
                        <div class="b-in b-in-006">Box spacer</div>
                    </div>
                    
                    
                    <div class="b-out b-out-012">
                        <div class="b-in b-in-012">Box header</div>
                    </div>
                    <div class="span-6 block-011">
                          <div class="filler"></div>
                            
                            <div class="clearfix pos">
                                <div class="span-3">
                                    <a href="<?php print url_for('@suggest') ?>">Suggest a story</a>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="span-3 last">
                                    <a href="<?php print url_for('@report') ?>">Report a mistake</a>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                        </div>
                    </div>
                    <!--box footer-->
                    <div class="b-out b-out-004">
                        <div class="b-in b-in-004">Box footer</div>
                    </div>
                </div>
                <!--LEFT COLUMN END-->
                
                
               <!--RIGHT COLUMN START-->
								<div class="span-6 last">
										<!--And what's the story -->
										<div class="span-6">
												<div class="b-out block-043"><a href="#"><span>And what's the story</span></a></div>
												
												<div class="span-6 block-004">
                          <?php if ($story['subtitle']): ?>
                            <h4><?php echo htmlspecialchars($story['subtitle'], ENT_COMPAT, 'utf-8') ?></h4>
                          <?php endif ?>
                           
                           <?php if ($story['teaser']): ?>
                             <p class="intro"><?php echo htmlspecialchars($story['teaser'], ENT_COMPAT, 'utf-8') ?></p>
                           <?php endif ?>

                           <?php echo foaf_story_filter($story['description'], 'story-'.$story['id'].'-version-'.$story['version']) ?>
                        </div><!--block-004-->
												
												
                        
                        <div class="span-6 block-008">
                          <div class="divider">Dotted divider</div>
                        </div><!-- block-008-->
												
                        
                        <div class="b-out b-out-009"></div>
                    </div>
                    <!--And what's the story - END-->
                    
                    <div class="span-6 b-out-011">Box Spacer</div>
                    
                    
                    <div class="span-6">

                      <?php include_component('story_comment', 'comments', array('story_id' => $story['id'], 'story_version' => $story['version'])); ?>
                        
                    </div>                   
                </div>
                <!--RIGHT COLUMN END-->
            </div> 
            
            <div class="b-out b-out-001">
              <div class="b-in b-in-003"></div>
            </div>
        </div>
      
    </div><!--#content-->



