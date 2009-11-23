<?php slot('body tag'); ?>
<body id="contact-page">
<?php end_slot();?>

<?php slot('breadcrumb'); ?>
<ul>
    <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
    <li class="selected"><a href="<?php echo url_for('@suggest') ?>">Suggest a story</a></li>
</ul>
<?php end_slot();?>

<!--#MAIN CONTENT-->
<div id="content" class="span-12">
<div class="span-12">

		<!--MAIN HEADING-->
		<div class="span-12" id="block-044">
			<div class="top left-offset-white offset-text">Top</div>		
			<div class="inner">
				<h2 class="sIFR-c4">Suggest a story</h2>
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
				<!--FORM SIDE LEFT COLUMN-->
				<div class="span-8">
						<div class="block-034">
            		<!--Search string-->
                <div class="search-string">
                		<div class="inner clearfix">
                   			<p class="sIFR-c4">Suggest a story</p>
                     		<p class="hidden">Suggest a story</p>
                   	</div>
                		<div class="end offset-text">Arrow end</div>
            		</div>
						</div><!--block-034-->
								
						<div class="span-8 left-offset-white">
								<form class="form style-001 action="<?php echo url_for('@suggest') ?>" method="POST">
								        <?php print $form->renderHiddenFields()?>
										<fieldset>
						                  <?php if ($form->hasErrors()): ?>
							  				<legend class="error">Please complete ALL of the fields</legend>
							              <?php else: ?>
							  				<legend>Please complete all of the following</legend>
							              <?php endif ?>
												<?php //print $form->renderGlobalErrors() ?>
												
												<?php if ($form['name']->hasError()): ?>
												<dl class="clearfix error">
												<?php else: ?>
												<dl class="clearfix">
												<?php endif ?>
														<dt>
																<label for="name">Name</label>
														</dt>
														<dd><?php echo $form['name']->render() ?></dd>
												</dl>
												<?php if ($form['email']->hasError()): ?>
												<dl class="clearfix error">
												<?php else: ?>
												<dl class="clearfix">
												<?php endif ?>
														<dt>
																<label for="email">Email</label>
														</dt>
														<dd><?php echo $form['email']->render() ?></dd>
												</dl>
												<?php if ($form['message']->hasError()): ?>
												<dl class="clearfix error">
												<?php else: ?>
												<dl class="clearfix">
												<?php endif ?>
														<dt>
																<label for="comment">Your suggestion</label>
														</dt>
														<dd><?php echo $form['message']->render() ?></dd>
												</dl>
												<?php if ($form['captcha']->hasError()): ?>
												<dl class="clearfix error">
												<?php else: ?>
												<dl class="clearfix">
												<?php endif ?>
														<dt>
																<label for="captcha">Security check</label>
														</dt>
														<dd><?php echo $form['captcha']->render() ?></dd>
												</dl>
												<dl class="submit clearfix">
														<dt>
																<label for="submit">Submit</label>
														</dt>
														<dd>
																<input type="submit" name="submit" id="submit" value="Submit" />
														</dd>
												</dl>
										</fieldset>
								</form>
						</div>
						<div class="b-out box-left-out-017">
								<div class="b-in box-left-in-017">Box footer</div>
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
