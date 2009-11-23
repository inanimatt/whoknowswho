<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
						
						
						<div class="span-6 block-046">
							<form class="form style-001" name="comments-form" method="post" action="#comments-area">
								<?php print $form->renderHiddenFields()?>
								<?php echo $form->renderGlobalErrors() ?>
								<fieldset>
									<legend>
										<?php if ($form->hasErrors()): ?>
											<td class="error">Please complete ALL of the following fields</td>
										<?php else: ?>
											<td>Please complete ALL of the following fields</td>
										<?php endif ?>
									</legend>
									<dl class="clearfix<?php if ($form['username']->hasError()) { print " error";} ?>">

										<dt>
											<label for="email">Name</label>
										</dt>
										<dd>
											<?php echo $form['username']->render() ?>
										</dd>
									</dl>
									<dl class="clearfix<?php if ($form['email']->hasError()) { print " error";} ?>">

										<dt>
											<label for="email">Email</label>
										</dt>
										<dd>
											<?php echo $form['email']->render() ?>
										</dd>
									</dl>
									<dl class="clearfix<?php if ($form['comment']->hasError()) { print " error";} ?>">

										<dt>
											<label for="suggestion">Comment</label>
										</dt>
										<dd>
											<?php echo $form['comment']->render() ?>
										</dd>
									</dl>
                                    
                                    
                                    
                                    
									<dl class="clearfix<?php if ($form['captcha']->hasError()) { print " error";} ?>">

										<dt>
											<label for="suggestion">Security<br>check</label>
										</dt>
										<dd><?php echo $form['captcha']->render() ?></dd>
									</dl>

									<dl class="clearfix<?php if ($form['terms']->hasError()) { print " error";} ?>">

										<dt>
											<label for="terms">Terms</label>
										</dt>
										<dd class="terms"><?php echo $form['terms']->render() ?> I have read and accept the <a href="<?php echo url_for('@terms') ?>">Terms and Conditions.</a></dd>
									</dl>

									<dl class="submit clearfix">
										<dt class="hidden">
											<label for="submit">Preview</label>

										</dt>
										<dd>
											<input type="submit" name="submit" id="submit" value="Submit" />
										</dd>
                                        
                                        
                                        
									</dl>
								</fieldset>
							</form>
							<div class="divider">Dotted divider</div>

						</div><!--block-046-->
