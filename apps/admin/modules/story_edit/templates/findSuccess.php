<div class="container">
  <h1><a href="<?php echo url_for('story_edit/index') ?>">Story editor</a></h1>
  <h2>Search results</h2>

  <p>Pick a fact, or go back and <?php echo link_to('search again', 'story_edit/view?id='.$story['id']) ?>. Results are limited to 50 rows, so if you can't find what you're after, try refining your search.</p>
  <table>
    <thead>
      <tr>
        <th>Primary entity</th>
        <th>Fact title<span class="small quiet"><br>type</span></th>
        <th>Related entity</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>  
    <?php foreach ($result->execute() as $idx => $r): ?>
      <tr<?php if ($idx % 2 == 0) echo ' class="even"'?>>
        <td><?php echo link_to($r['Entity'], 'entity_edit',  $r['Entity'], array('target' => '_blank')) ?></td>
        <td><?php echo link_to($r, 'fact_edit', $r, array('target' => '_blank')) ?><br>
          <span class="small quiet"><?php echo htmlspecialchars($r['FactType'], ENT_COMPAT, 'utf-8') ?></span></td>
        <td><?php echo $r['RelatedEntity'] ? link_to($r['RelatedEntity'], 'entity_edit',  $r['RelatedEntity'], array('target' => '_blank')) : '' ?></td>
        <td><form action="<?php echo url_for('story_edit/add?story='.$story['id']) ?>" method="post" accept-charset="utf-8"><input type="hidden" name="fid" value="<?php echo $r['id'] ?>"><input type="submit" name="add" value="Add to story"></form></td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
  
  <p><a href="<?php echo url_for('fact_new') ?>">Add a new fact</a></p>
  
</div>