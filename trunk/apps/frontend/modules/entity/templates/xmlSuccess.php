<map>
  <entities>
    <main id="<?php print htmlspecialchars($entity['id'], ENT_COMPAT, 'utf-8') ?>" n="<?php print htmlspecialchars($entity['name'], ENT_COMPAT, 'utf-8') ?>" t="<?php print $entity['entity_type_id'] ?>">
      <photourl><?php print htmlspecialchars($entity->getPhotoUrlMedium(), ENT_COMPAT, 'utf-8') ?></photourl>
      <photourlbig><?php print htmlspecialchars($entity->getPhotoUrlLarge(), ENT_COMPAT, 'utf-8') ?></photourlbig>
      <welcome>Welcome to my map. Click "view full size" to explore it further.</welcome>
      <largemap><?php print htmlspecialchars(url_for('@entity_map?entity_type='.$entity['EntityType']['url_slug'].'&id='.$entity['slug']), ENT_COMPAT, 'utf-8')  ?></largemap>
    </main>

  <?php foreach ($all_connections as $connection): ?>
    <ent id="<?php print htmlspecialchars($connection['id'], ENT_COMPAT, 'utf-8') ?>" n="<?php print htmlspecialchars( $connection['name'], ENT_COMPAT, 'utf-8') ?>" d="<?php echo isset($distances[$connection['id']]) ? $distances[$connection['id']] : 0 ?>" t="<?php print htmlspecialchars($connection['entity_type_id'], ENT_COMPAT, 'utf-8') ?>" c="<?php echo htmlspecialchars($connection['connectedness'], ENT_COMPAT, 'utf-8') ?>"/>
  <?php endforeach ?>

  </entities>
  <connections>
  <?php foreach ($facts as $fact): ?>
    <conn id="<?php print htmlspecialchars($fact['id'], ENT_COMPAT, 'utf-8') ?>" a="<?php print htmlspecialchars($fact['entity_id'], ENT_COMPAT, 'utf-8') ?>" b="<?php print htmlspecialchars($fact['related_entity_id'], ENT_COMPAT, 'utf-8') ?>" t="<?php print htmlspecialchars($fact['fact_type_id'], ENT_COMPAT, 'utf-8') ?>"/>
  <?php endforeach ?>
  </connections>
</map>