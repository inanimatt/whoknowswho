<div class="container">
<h1>Story editor</h1>

<?php if ($pager->haveToPaginate()): ?>
  Showing <?php echo $pager->getFirstIndice() ?> to <?php echo $pager->getLastIndice() ?> of <?php echo $pager->getNumResults() ?> results.<br>
  <?php if ($pager->getPreviousPage()): ?>
    <?php echo link_to('« Previous', 'story_edit/index?page='.$pager->getPreviousPage()) ?>
  <?php endif ?>
  
  <?php if ($pager->getNextPage()): ?>
    <?php echo link_to('Next »', 'story_edit/index?page='.$pager->getNextPage()) ?>
  <?php endif ?>
  
<?php endif ?>

<table>
  <thead>
    <tr><th>Title</th><th>Owner</th><th>Created</th></tr>
  </thead>
<?php foreach ($stories as $item): ?>
  <tr>
    <td><a href="<?php echo url_for('story_edit/view?id='.$item['id']) ?>"><?php echo htmlspecialchars($item['title'], ENT_COMPAT, 'utf-8') ?></a></td>
    <td><?php echo htmlspecialchars($item['Creator'], ENT_COMPAT, 'utf-8') ?></td>
    <td><?php echo htmlspecialchars($item['updated_at'], ENT_COMPAT, 'utf-8') ?></td>
  </tr>
<?php endforeach ?>
</table></div>