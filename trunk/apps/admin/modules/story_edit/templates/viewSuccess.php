<?php use_helper('Foaf')?>
<div class="container">
  <h1><a href="<?php echo url_for('story_edit/index') ?>">Story editor</a></h1>

  <h2><?php echo htmlspecialchars($story['title'], ENT_COMPAT, 'utf-8') ?></span></h2>
  <p><?php echo foaf_story_filter($story['description'], 'story'.$story['id'].'version-'.$story['version']) ?></p>

  <div class="span-6 quiet">Created: <?php echo htmlspecialchars($story['created_at'], ENT_COMPAT, 'utf-8') ?></div>
  <div class="span-6 quiet">Owner: <?php echo htmlspecialchars($story['Creator'], ENT_COMPAT, 'utf-8') ?></div>
  <div class="span-6 quiet">Last edited: <?php echo htmlspecialchars($story['updated_at'], ENT_COMPAT, 'utf-8') ?></div>
  <div class="span-6 quiet last"><?php echo link_to('Edit story content', 'story_edit', $story) ?></div>
</div>

<div class="container prepend-top">
  <hr>
  <h2>Story column</h2>

  <form action="<?php echo url_for('story_edit/view?id='.$story['id']) ?>" method="post" accept-charset="utf-8">
    <table>
      <thead>
        <tr>
          <th>Order</th>
          <th>Primary entity<br><span class="small">type</span></th>
          <th>Linking text</th>
          <th>Related entity<br><span class="small">type</span></th>
          <th>Entity order</th>
          <th>Fact</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($story['StoryFacts']) : foreach ($story['StoryFacts'] as $sf): ?>
        <tr>
          <td>
            <input type="text" name="story_fact[<?php echo $sf['fact_id'] ?>][story_order]" value="<?php echo $sf['story_order'] ?>" class="fact_order_field">
          </td>
          <td>
            <?php echo htmlspecialchars($sf['Fact']['Entity'], ENT_COMPAT, 'utf-8') ?><br>
            <span class="small right"><?php echo htmlspecialchars($sf['Fact']['Entity']['EntityType'], ENT_COMPAT, 'utf-8') ?></span>
          </td>
          <td><input type="text" name="story_fact[<?php echo $sf['fact_id'] ?>][description]" value="<?php echo $sf['description'] ?>"></td>
          <td>
            <?php echo htmlspecialchars($sf['Fact']['RelatedEntity'], ENT_COMPAT, 'utf-8') ?><br>
            <span class="small right"><?php echo htmlspecialchars($sf['Fact']['RelatedEntity']['EntityType'], ENT_COMPAT, 'utf-8') ?></span>
          </td>
        
          <td><select name="story_fact[<?php echo $sf['fact_id'] ?>][primary_entity]" size="1">
            <option value="entity"<?php echo $sf['primary_entity'] == 'entity' ? ' selected' : '' ?>>Primary &rarr; Related</option>
            <option value="related"<?php echo $sf['primary_entity'] == 'related' ? ' selected' : '' ?>>Related &rarr; Primary</option>
          </select></td>
          <td><?php echo link_to('View Fact', 'fact_edit', $sf['Fact']) ?></td>
          <td><input type="checkbox" name="story_fact[<?php echo $sf['fact_id'] ?>][delete]" value="1"></td>
        </tr>
  
      <?php endforeach; endif; ?>
      </tbody>
    </table>
    <input type="submit" name="save" value="Update">
  </form>
  
  <hr class="space">
  
  <form action="<?php echo url_for('story_edit/find?id='.$story['id']) ?>" method="post" accept-charset="utf-8">
    <div class="box">
      <h3>Add a fact</h3>
      <p><label for="entity">Start by finding an Entity (person, company, etc):</label><br>
         <input type="search" name="entity" value="" id="entity" results="15">
         <input type="submit" name="search" value="Search">
      </p>
    </div>
  </form>

</div>



<style type="text/css">
  .fact_order_field
  {
    width: 2em;
  }
  th
  {
    vertical-align: top;
  }
</style>