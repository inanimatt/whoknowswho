		
<div class="span-6" id="comments-area">
						<div class="b-out b-out-010">Box header</div>

						<div class="span-6 block-009">
							<div class="span-3">
								<h4><?php print htmlspecialchars($total_comments, ENT_COMPAT, 'UTF-8'); ?> comments so far</h4>
							</div>
							
							<div class="span-3 last">
								<p id="add-comment"><a href="#">Add a comment</a></p>
							</div>
							<div class="span-6">

								<div class="divider">Dotted divider</div>
								
						        <?php if ($sf_user->hasFlash('comment_submitted')): ?>
                          		  <p class="thanks"><?php echo $sf_user->getFlash('comment_submitted') ?>
                                <?php endif; ?>
							</div>
						</div><!--block-009-->

		                <?php include_partial('story_comment/form', array('form' => $form)) ?>


</div>


<div class="span-6 block-010">

<?php if ($total_comments > 0): ?>
	<?php foreach ($story_comments as $story_comment): ?>
		
		<div class="comment">
			<p><?php echo htmlspecialchars($story_comment['comment'], ENT_COMPAT, 'UTF-8') ?></p>
			<ul class="clearfix">
				<li><?php print htmlspecialchars($story_comment['username'], ENT_COMPAT, 'UTF-8') ?></li>
				<li><?php print link_to('Report this', url_for('@report_comment').'?id='.$story_comment['id']) ?></li>
				<li><?php print date('dS M Y @ G:i', strtotime($story_comment['created_at'])) ?></li>
			</ul>
			<div class="divider">Dotted divider</div>
		</div><!--comment-->
	<?php endforeach; ?>
<?php endif; ?>
	
  <?php if ($total_comments > 5): ?>
    <div class="more-comments"></div>
	<div class="span-6">
		<p class="showall"><a href="<?php print $story_comment['story_id'] ?>">Show all comments</a></p>
	</div>
  <?php endif ?>
</div>
                        