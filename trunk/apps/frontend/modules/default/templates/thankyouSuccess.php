<?php slot('body tag'); ?>
	<body id="contact-page">
<?php end_slot();?>

<?php slot('breadcrumb'); ?>
<ul>
    <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
    <li class="selected"><a href="<?php echo url_for('@thankyou') ?>">Thank you</a></li>
</ul>
<?php end_slot();?>


<!--#MAIN CONTENT-->
<div id="content" class="span-12">
	<div class="span-12">
	
		<!--MAIN HEADING-->
		<div class="span-12" id="block-044">
			<div class="top left-offset-white offset-text">Top</div>

			<div class="inner">
				<h2 class="sIFR-c4">Thank you</h2>
			</div>
			<div class="cubt offset-text">Box Bottom</div>
			<div class="bottom left-offset-white offset-text">Bottom</div>
		</div>
		<!--#block-044-->

		
		<!--12 column spacer-->
		<div class="b-out b-out-001">
			<div class="b-in b-in-001"></div>
		</div>
		<div class="b-out b-out-001">
			<div class="b-in b-in-003"></div>
		</div>
		
		<div class="span-12">
			<!--FORM SIDE LEFT COLUMN-->

			<div class="span-8">
				<div class="block-034">
					<!--Search string-->
					<div class="search-string">
						<div class="inner clearfix">
							<p class="sIFR-c4">Thank you</p>
							<p class="hidden">Thank you</p>
						</div>

						<div class="end offset-text">Arrow end</div>
					</div>
				</div><!--block-034-->
				
				
				<div class="span-8 left-offset-white block-047">
					<p class="message">Thank you for your comment.</p>
					<p><a href="<?php print url_for('@homepage') ?>">Click here to return to home page</a></p>
				</div>

				<div class="b-out box-left-out-014">
					<div class="b-in box-left-in-014">Box footer</div>
				</div>
			</div>
			<!--RIGHT COLUMN-->
			<div class="span-4 last">
				<div class="span-4 block-013">
					<!--Suggest a story-->
					<div class="span-4 block-016">
						<div class="span-4 header"></div>
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
