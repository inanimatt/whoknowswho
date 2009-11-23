<?php slot('breadcrumb') ?>
<ul>
  <li><a href="<?php echo url_for('@homepage') ?>">Home</a></li>
  <li><a href="<?php echo url_for('@entity_list?entity_type='.$entity['EntityType']['url_slug'])?>"><?php echo htmlspecialchars(ucfirst($entity['EntityType']['url_slug']), ENT_COMPAT, 'utf-8') ?></a></li>
  <li><a href="<?php echo url_for('@entity_view?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>"><?php echo htmlspecialchars(shortenTitle($entity['name']), ENT_COMPAT, 'utf-8') ?></a></li>
  <li class="selected"><a href="<?php echo url_for('@entity_interesting_facts?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug'])  ?>">Interestingly enough…</a></li>
</ul>
<?php end_slot();?>



<?php foreach ($facts as $fact): ?>
  <p><?php print htmlspecialchars($fact->getEntity(), ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['title'], ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['RelatedEntity']['name'], ENT_COMPAT, 'utf-8') ?> 
    <span class="sources">source - <?php foreach ($fact['Sources'] as $source) { print link_to(htmlspecialchars($source['title'], ENT_COMPAT, 'utf-8'), htmlspecialchars($source['url'], ENT_COMPAT, 'utf-8')). '&nbsp;&nbsp;&nbsp;'; } ?></span></p>
<?php endforeach ?>