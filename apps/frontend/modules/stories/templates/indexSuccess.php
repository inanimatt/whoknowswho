<?php slot('body tag'); ?>
	<body id="story-list-page">
<?php end_slot();?>
<?php slot('breadcrumb') ?>
<ul>
	<li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
	<?php if ($entity): ?>
	  <li><a href="<?php echo url_for('@entity_list?entity_type='.$entity['EntityType']['url_slug'])?>"><?php echo htmlspecialchars(ucfirst($entity['EntityType']['url_slug']), ENT_COMPAT, 'utf-8') ?></a></li>
	  <li><a href="<?php echo url_for('@entity_view?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>"><?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?></a></li>
	  <li class="selected"><a href="<?php echo url_for('@entity_story_list?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>">Stories</a></li>
	<?php else: ?>
	  <li class="selected"><a href="<?php echo url_for('@story_list') ?>">Stories</a></li>
	<?php endif ?>
</ul>
<?php end_slot(); ?>
<!--#MAIN CONTENT-->
<div id="content" class="span-12">
	<div class="span-12">
	
		<!--MAIN HEADING-->
			<div class="span-12" id="block-044">
				<div class="top left-offset-white offset-text">Top</div>		
				<div class="inner">
					<h2 class="sIFR-c4">Stories<?php if ($entity): ?> involving <?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?><?php endif ?></h2>
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
					<div class="count">
					  <?php if ($pager->getNbResults() == 0): ?>
					    <p>No results</p>
					  <?php else: ?>
						<p>Showing results
						  <span class="showing">
						    <?php echo $pager->getFirstIndice() ?>-<?php echo $pager->getLastIndice() ?>
						  </span> 
						  of <?php print $pager->getNbResults() ?>
						</p>
					  <?php endif ?>
					</div>
					<!--drop down filter menu-->
					<!-- <div class="drop-down">
						<label for="search-select">Sort by</label>
						<select name="search-select" id="search-select">
							<option>Connectedness, Highest first</option>
							<option>Connectedness, Lowest first</option>
							<option>Connectedness, Highest first</option>
							<option>Connectedness, Lowest first</option>
						</select>
					</div> -->
				</form>
			</div>
			<div class="search-spacer">Spacer</div>
		</div>
		<!--SEARCH RESULTS-->
		<div class="span-12">
			<!--Entity search result-->
			<!--Story search result-->
			<?php if ($pager->getNbResults() == 0): ?>
				<div class="block-035 story">
					<ul>
						<li class="clearfix">
							<div class="info">
								<p>Sorry, there are currently no stories about <a href="<?php echo url_for('@entity_view?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>"><?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?></a>. Would you like to <a href="<?php echo url_for('@suggest') ?>">suggest one?</a></p>
							</div>
						</li>
					</ul>
					<div class="divider offset-text">Divider</div>
				</div>
				<!--block-035-->
			<?php endif ?>
			
			<?php foreach ($pager->getResults() as $s): ?>
			<div class="block-035 story">
				<ul>
					<li class="clearfix">
						<div class="info">
							<h4><a href="<?php echo $entity ? $s->getEntityContextUrl($entity) : $s->getUrl() ?>"><?php echo htmlspecialchars($s['title'], ENT_COMPAT, 'utf-8') ?></a></h4>
							<!--
							<div class="clearfix">
								 <p class="date"><?php print date('jS F Y', strtotime($s['created_at'])) ?></p>
								 <p class="author">Author <span class="name"><?php echo htmlspecialchars($s['author'], ENT_COMPAT, 'utf-8') ?></span></p>
							</div>
							-->
							<p><?php echo htmlspecialchars($s['teaser'], ENT_COMPAT, 'utf-8') ?></p>
						</div>
						<div class="rating-area">
							<div class="pos" >
								<div class="left">Interest</div>
								<div class="right">
									<div class="progress-bar">
										<div class="cutout"></div>
										<div class="top" title="<?php echo htmlspecialchars($s['interest'], ENT_COMPAT, 'utf-8') ?>"></div>
										<div class="bottom"></div>
									</div>
									<!--progress-bar-->
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
								</div>
							</div>
						</div>
						<!--rating-area-->
					</li>
				</ul>
				<div class="divider offset-text">Divider</div>
			</div>
			<!--block-035-->
			<?php endforeach ?>
			<?php if ($pager->haveToPaginate()): ?>
			<!--PAGE LISTING-->
			<div class="block-038">
				<div class="poo">
					<ul class="clearfix">
						<li class="prev"><a href="<?php echo url_for('@story_list?page='.$pager->getPreviousPage()) ?>">Previous</a></li>
						<li class="page">Page <?php print $pager->getPage() ?> of <?php print $pager->getLastPage() ?></li>
						<li><a href="<?php echo url_for('@story_list?page=1') ?>">First</a></li>
						<?php foreach ($pager->getLinks() as $page): ?>
						<?php if ($page == $pager->getPage()): ?>
						<li><?php echo $page ?></li>
						<?php else: ?>
						<li><a href="<?php echo url_for('@story_list?page='.$page) ?>"><?php echo $page ?></a></li>
						<?php endif; ?>
						<?php endforeach; ?>
						<li class="last"><a href="<?php echo url_for('@story_list?page='.$pager->getLastPage()) ?>">Last</a></li>
						<li class="next"><a href="<?php echo url_for('@story_list?page='.$pager->getNextPage()) ?>">Next</a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
			</div>
			<!--block-036-->
			<?php endif ?>
		</div>
		<div class="b-out b-out-001">
			<div class="b-in b-in-001"></div>
		</div>
	</div>
</div>
<!--#content-->
