<?php slot('body tag'); ?>
  <body id="entity-list-page">
<?php end_slot();?>

<?php slot('breadcrumb') ?>
<ul>
  <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
  <li class="selected"><a href="<?php echo url_for('@entity_list?entity_type='.$entity_type['url_slug'])?>"><?php echo htmlspecialchars(ucfirst($entity_type['url_slug']), ENT_COMPAT, 'utf-8') ?></a></li>
</ul>
<?php end_slot(); ?>

<!--#MAIN CONTENT-->
<div id="content" class="span-12">
	<div class="span-12">
	
		<!--MAIN HEADING-->
			<div class="span-12" id="block-044">
				<div class="top left-offset-white offset-text">Top</div>		
				<div class="inner">
					<h2 class="sIFR-c4"><?php echo htmlspecialchars(ucfirst($entity_type['url_slug']), ENT_COMPAT, 'utf-8') ?></h2>
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
						<p>Showing results <span class="showing"><?php echo $pager->getFirstIndice() ?>-<?php echo $pager->getLastIndice() ?></span> of <?php print $pager->getNbResults() ?></p>
					</div>
					<!--drop down filter menu-->
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
				</form>
			</div>
			<div class="search-spacer">Spacer</div>
		</div>
		<!--SEARCH RESULTS-->
			<div class="span-12">
			<!--Entity search result-->

                <?php foreach ($pager->getResults() as $e): ?>
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
                                    <li class="first"><a  href="<?php echo $e->getStoriesUrl() ?>"> Stories involving <?php echo htmlspecialchars($e['name'], ENT_COMPAT, 'utf-8') ?></a></li>
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

			<?php if ($pager->haveToPaginate()): ?>
			<!--PAGE LISTING-->
			<div class="block-038">
				<div class="poo">
					<ul class="clearfix">
						<li class="prev"><a href="<?php echo $url . $pager->getPreviousPage() ?>">Previous</a></li>
						<li class="page"><?php print $pager->getPage() ?> of <?php print $pager->getLastPage() ?></li>
						<li><a href="<?php echo $url . $pager->getFirstPage() ?>">First</a></li>
						<?php foreach ($pager->getLinks() as $page): ?>
						<?php if ($page == $pager->getPage()): ?>
						<li><?php echo $page ?></li>
						<?php else: ?>
						<li><a href="<?php echo $url . $page ?>"><?php echo $page ?></a></li>
						<?php endif; ?>
						<?php endforeach; ?>
						<li class="last"><a href="<?php echo $url . $pager->getLastPage() ?>">Last</a></li>
						<li class="next"><a href="<?php echo $url . $pager->getNextPage() ?>">Next</a></li>
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