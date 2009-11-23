<?php if ($total_comments > 0): ?>
	<?php foreach ($story_comments as $story_comment): ?>
		
		<div class="comment">
			<p><?php echo htmlspecialchars($story_comment['comment'], ENT_COMPAT, 'UTF-8') ?></p>
			<ul class="clearfix">
				<li><?php print htmlspecialchars($story_comment['username'], ENT_COMPAT, 'UTF-8') ?></li>
				<li><?php print link_to('Report this', '/') ?></li>
				<li><?php print date('dS M Y @ G:i', strtotime($story_comment['created_at'])) ?></li>
			</ul>
			<div class="divider">Dotted divider</div>
		</div><!--comment-->
	<?php endforeach; ?>
<?php endif; ?>