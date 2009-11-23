<?php slot('body tag'); ?>
  <body id="text-page">
<?php end_slot();?>

<?php slot('breadcrumb'); ?>
<ul>
    <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
    <li class="selected"><a href="<?php echo url_for('@rules') ?>">House rules</a></li>
</ul>
<?php end_slot();?>
<!--#MAIN CONTENT-->

	<div id="content" class="span-12">
		<div class="span-12">
			
			<!--MAIN HEADING-->
		<div class="span-12" id="block-044">
			<div class="top left-offset-white offset-text">Top</div>		
			<div class="inner">
				<h2 class="sIFR-c4">House rules</h2>
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
			<div class="span-12">
				<!--LEFT COLUMN-->
				<div class="span-8">
					<!--TEXT BLOCK-->
					<div class="block-041">
						<div class="span-8 content left-offset-white">
							<h5>Rules</h5>
                            
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<a href="#" class="btt">back to top</a> </div>
					</div>
					<!--block-041-->
					<div class="b-out box-left-out-014 mb10">
						<div class="b-in box-left-in-014">Box footer</div>
					</div>
					<!--TEXT BLOCK END-->

				</div>
				<!--RIGHT COLUMN-->
				<div class="span-4 last">
					<div class="span-4 block-013">
						<!--Suggest a story-->
						<div class="span-4 block-016">
							<div class="span-4 header"> <a href="<?php print url_for('@about') ?>" class="link1">About</a> <a href="<?php print url_for('@terms') ?>" class="link2">Terms and Conditions</a> </div>
							<div class="span-4 content">
							<div class="span-4 pos"> 
								<a href="<?php print url_for('@suggest') ?>">Suggest a story</a>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
								<a href="<?php print url_for('@report') ?>">Report a mistake</a>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							</div>
							</div>
							<div class="span-4 footer"></div>
						</div>
						<!--block-014-->
					</div>
					<!--block-013-->
				</div>
			</div>
	</div>
	<!--#MAIN CONTENT END-->
