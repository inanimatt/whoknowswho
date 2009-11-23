<ul>
  <?php foreach ($facts as $fact): ?>
    <li>
      <?php if ($fact['start'] || $fact['end']): ?>
        <span class="date">(
          <?php 
            echo $fact['start'] ? date_create($fact['start'])->format('Y') : '';
          ?> – <?php 
            echo $fact['end']   ? date_create($fact['end'])->format('y'): ''; 
          ?>
        )</span>
      <?php endif ?>
      <?php print htmlspecialchars($fact->getEntity(), ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['title'], ENT_COMPAT, 'utf-8') ?> <?php print htmlspecialchars($fact['RelatedEntity']['name'], ENT_COMPAT, 'utf-8') ?> 
      <span class="sources">source - <?php foreach ($fact['Sources'] as $source) { print link_to(htmlspecialchars($source['title'], ENT_COMPAT, 'utf-8'), htmlspecialchars($source['url'], ENT_COMPAT, 'utf-8')). '&nbsp;&nbsp;&nbsp;'; } ?></span></li>
      
  <?php endforeach ?>

</ul>
