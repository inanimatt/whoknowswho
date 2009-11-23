<?php slot('body tag'); ?>
  <body id="search-page">
<?php end_slot();?>

<?php slot('breadcrumb') ?>
<ul>
  <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
  <li class="selected"><a href="#">Search</a></li>
</ul>
<?php end_slot(); ?>


<!--#MAIN CONTENT-->   
  <div id="content" class="span-12">
        <div class="span-12">       
        	
			<!--MAIN HEADING-->
			<div class="span-12" id="block-044">
				<div class="top left-offset-white offset-text">Top</div>		
				<div class="inner">
					<h2 class="sIFR-c4">Search results</h2>
				</div>
				<div class="cubt offset-text">Box Bottom</div>
				<div class="bottom left-offset-white offset-text">Bottom</div>
			</div><!--#block-044-->
        	
            <!--12 column spacer-->

            <div class="b-out b-out-001">
            	<div class="b-in b-in-001"></div>
            </div>
            <div class="b-out b-out-001">
            	<div class="b-in b-in-003"></div>
            </div>
            

            <!--Top of search including drop down and raio buttons-->
            <div class="span-12">
            	<div class="block-034">

                	<form action="file.php" method="post" id="search-filter-form">
                		<!--Search string-->
                        <div class="search-string">
                        	<div class="inner clearfix">
                            	<p class="sIFR-c4">Your search for '<span class="result"><?php print htmlspecialchars($terms, ENT_COMPAT, 'utf-8') ?></span>' returned <?php echo htmlspecialchars($num_results, ENT_COMPAT, 'utf-8') ?> results</p>
                            	<p class="hidden">Your search for '<span class="result"><?php print htmlspecialchars($terms, ENT_COMPAT, 'utf-8') ?></span>' returned <?php echo htmlspecialchars($num_results, ENT_COMPAT, 'utf-8') ?> results</p>
                            </div>

                            <div class="end offset-text">Arrow end</div>
                        </div>
                        
                        <!--Search result count-->
                        <div class="count">
                          <?php if ($num_results == 0): ?>
                            <p>No results.</p>
                          <?php else: ?>
                        	<p>Showing results <span class="showing"><?php echo htmlspecialchars($showing, ENT_COMPAT, 'utf-8') ?></span> of <?php echo htmlspecialchars($num_results, ENT_COMPAT, 'utf-8') ?></p>
                          <?php endif ?>
                        </div>

                        
                        <?php if ($num_results != 0): ?>
                        <!--Radio buttons-->
						
                        <div class="radio-buttons">
                        	<label for="people-chk" class="people<?php if ($filter == 'stories') {print '-off';}?>" id="people">
                            	People/Groups
                            	<input name="people-chk" id="people-chk" type="checkbox" value="<?php print $url_no_filter . '&filter=stories' ?>" checked="<?php if ($filter == 'stories') {print 'checked';}?>">
                            </label>
                            <label for="stories-chk" class="stories<?php if ($filter == 'entities') {print '-off';}?>" title="stories"  id="stories">
                            	Stories
                            	<input name="stories-chk" id="stories-chk" type="checkbox" value="<?php print $url_no_filter . '&filter=entities' ?>" checked="<?php if ($filter == 'entities') {print 'checked';}?>">
                            </label>
                        </div>
						
                        <?php endif ?>
                        
					
                        <!--drop down filter menu-->
							<!--
					  <div class="drop-down">
						<label for="search-select">Sort by</label>
						<select name="search-select" id="search-select">
							<option value="<?php print $strippedurl ?>?orderby=name&amp;order=ASC">Name, A's first</option>
							<option value="<?php print $strippedurl ?>?orderby=name&amp;order=DESC">Name, Z's first</option>
							<option value="<?php print $strippedurl ?>?orderby=connectedness&amp;order=DESC">Connectedness, Highest first</option>
							<option value="<?php print $strippedurl ?>?orderby=connectedness&amp;order=ASC">Connectedness, Lowest first</option>
							<option value="<?php print $strippedurl ?>?orderby=interest&amp;order=DESC">Interest, Highest first</option>
							<option value="<?php print $strippedurl ?>?orderby=interest&amp;order=ASC">Interest, Lowest first</option>
						</select>
					  </div>
					  -->
                    </form>
                </div>
                <div class="search-spacer">Spacer</div>

            </div>
            

            <!--SEARCH RESULTS-->
            <div class="span-12">
                       
                <?php if ($entities): ?>
            	<!--Entity search result-->
                
                <?php foreach ($entities as $key => $e): ?>
                <div class="block-035 entity">
                    <ul>
                    	<li class="clearfix">
                        	<div class="image">
                        	    <?php print image_tag(htmlspecialchars($e->getPhotoURLMedium(), ENT_COMPAT, 'utf-8'))?>

                            </div>
                            <div class="info">
                            	<h4 class="blue"><a href="<?php echo $e->getUrl() ?>"><?php echo htmlspecialchars($e['name'], ENT_COMPAT, 'utf-8') ?></a></h4>
                                <h4 class="grey"><?php echo htmlspecialchars($e['subtitle'], ENT_COMPAT, 'utf-8') ?></h4>
                            	<p><?php echo htmlspecialchars($e['description'], ENT_COMPAT, 'utf-8') ?></p>
                                <ul class="links clearfix">
                                    <li class="first"><a  href="<?php echo htmlspecialchars($e->getStoriesUrl(), ENT_COMPAT, 'utf-8') ?>"> Stories involving <?php echo htmlspecialchars($e['name'], ENT_COMPAT, 'utf-8') ?></a></li>
                                </ul>
                            </div>
                            <div class="rating-area">
                                <div class="clearfix offset-text">Clearfix</div>
                                <div class="pos">
                                	<div class="left">Interest</div>
                                    <div class="right">
                                    	 <div class="progress-bar">

                                            <div class="cutout"></div>
                                            <div class="top" title="<?php echo htmlspecialchars($e['interest'], ENT_COMPAT, 'utf-8') ?>"></div>
                                            <div class="bottom"></div>
                                        </div><!--progress-bar-->
                                    </div>
                                </div>
                                <div class="clearfix offset-text">Clearfix</div>
                                <div class="pos">

                                	<div class="left">Connectedness</div>
                                    <div class="right">
                                    	 <div class="progress-bar">
                                            <div class="cutout"></div>
                                            <div class="top" title="<?php echo htmlspecialchars($e['connectedness'], ENT_COMPAT, 'utf-8') ?>"></div>
                                            <div class="bottom"></div>
                                        </div><!--progress-bar-->
                                    </div>

                                </div>
                            </div><!--rating-area-->
                        </li>
                    </ul>
                    <div class="divider offset-text">Divider</div>
                </div><!--block-035-->
                <?php endforeach ?>  
                <?php endif ?>                 

                
                 <!--Story search result-->
                 <?php if ($stories): ?>
                 <?php foreach ($stories as $key => $s): ?>
                <div class="block-035 story">
                    <ul>
                    	<li class="clearfix">
                            <div class="info">
                            	<h4 class="blue"><a href="<?php echo $s->getUrl() ?>"><?php echo htmlspecialchars($s['title'], ENT_COMPAT, 'utf-8') ?></a></h4>
                                <div class="clearfix">

                                  <!-- <p class="date"><?php print date('jS F Y', strtotime($s['created_at'])) ?></p>
                                    <p class="author">Author <span class="name"><?php echo htmlspecialchars($s['author'], ENT_COMPAT, 'utf-8') ?></span></p> -->
                                </div>
                                
                            	<p><?php echo htmlspecialchars($s['teaser'], ENT_COMPAT, 'utf-8') ?></p>
                                <!-- <p class="more"><a href="#">More stories</a></p> -->
                            </div>

                            <div class="rating-area">
                                <div class="pos" >
                                	<div class="left">Interest</div>
                                    <div class="right">
                                    	 <div class="progress-bar">
                                            <div class="cutout"></div>
                                            <div class="top" title="<?php echo htmlspecialchars($s['interest'], ENT_COMPAT, 'utf-8') ?>"></div>
                                            <div class="bottom"></div>

                                        </div><!--progress-bar-->
                                    </div>
                                </div>
                                <div class="clearfix offset-text">Clearfix</div>
                                <div class="pos" >
                                	<div class="left">Rating</div>
                                    <div class="right">
                                    	<div class="rating">
                                    		<ul>
                                        		<li class="star-on"><a href="#" class="offset-text">1</a></li>
                                            	<li class="star-on"><a href="#" class="offset-text">2</a></li>
                                            	<li class="star-on"><a href="#" class="offset-text">3</a></li>
                                            	<li class="star-off"><a href="#" class="offset-text">4</a></li>
                                            	<li class="star-off"><a href="#" class="offset-text">5</a></li>
                                         	</ul>
                                    	</div>
										<p><?php echo $s->getRating()->getTotalVotes() ?> ratings</p>
                                    </div>
                                </div>
                            </div><!--rating-area-->
                        </li>
                    </ul>
                    <div class="divider offset-text">Divider</div>
                </div><!--block-035-->
                <?php endforeach ?>  
                <?php endif ?>

                <?php if ($num_results != 0): ?>
                <!--PAGE LISTING-->
                <div class="block-038">
                	<div class="poo">

                        <ul class="clearfix">
                            <li class="prev"><a href="<?php echo $url.'&page='.$previous_page ?>">Previous</a></li>
                            <li class="page">Page <?php print $page ?> of <?php print $num_pages ?></li>
                            <li><a href="<?php echo $url.'&page=1' ?>">First</a></li>
                            <?php for ($counter = $lowrange; $counter < $page; $counter += 1): ?>
                              <li><a href="<?php print $url.'&page='.$counter ?>"><?php print $counter?></a></li>
                            <?php endfor ?>
                              	<li><?php print $counter?></li>
                            <?php for ($counter = $page +1; $counter <= $highrange; $counter += 1): ?>
                              <li><a href="<?php print $url.'&page='.$counter ?>"><?php print $counter?></a></li>
                            <?php endfor ?>
                            <li class="last"><a href="<?php echo $url.'&page='.$num_pages ?>">Last</a></li>

                            <li class="next"><a href="<?php echo $url.'&page='.$next_page ?>">Next</a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div><!--block-036-->
                <?php endif ?>
                
            </div>
            
            <div class="b-out b-out-001">
            	<div class="b-in b-in-001"></div>

            </div>
           
    	</div>	
  	</div><!--#content-->