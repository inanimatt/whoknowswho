<?php if ($fact['id']): ?>
  <?php echo link_to(image_tag('/sfDoctrinePlugin/images/new.png').' Add another source', 'fact_source/new?fact_id='.$fact['id']) ?> (currently <?php echo count($fact['Sources']) ?> sources)
<?php else: ?>
  <p>You can add another source after you've finished adding the fact. Just hit save.</p>
<?php endif ?>