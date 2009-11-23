<?php foreach ($facts as $fact): ?>
  <p><?php print htmlspecialchars($fact->getEntity(), ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['title'], ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['RelatedEntity']['name'], ENT_COMPAT, 'utf-8') ?> 
    <span class="sources">source - <?php foreach ($fact['Sources'] as $source) { print link_to(htmlspecialchars($source['title'], ENT_COMPAT, 'utf-8'), htmlspecialchars($source['url'], ENT_COMPAT, 'utf-8')). '&nbsp;&nbsp;&nbsp;'; } ?></span></p>
<?php endforeach ?>