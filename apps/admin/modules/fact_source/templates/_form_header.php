<?php if ($fact_source['fact_id']): ?>
  <?php echo link_to('View fact', '@fact_edit?id='.$fact_source['fact_id']) ?>
<?php endif ?>