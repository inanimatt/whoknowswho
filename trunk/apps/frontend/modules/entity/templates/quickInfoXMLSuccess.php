<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>


<entity id="<?php echo htmlspecialchars($entity['id'], ENT_COMPAT, 'utf-8') ?>" n="<?php echo htmlspecialchars($entity['name'], ENT_COMPAT, 'utf-8') ?>" t="<?php echo htmlspecialchars($entity['EntityType']['id'], ENT_COMPAT, 'utf-8') ?>">
  <position><?php echo htmlspecialchars($entity['subtitle'], ENT_COMPAT, 'utf-8') ?></position>
  <connectedness><?php echo htmlspecialchars($entity['connectedness'], ENT_COMPAT, 'utf-8') ?></connectedness>
  <interest><?php echo htmlspecialchars($entity['interest'], ENT_COMPAT, 'utf-8') ?></interest>
      <photourl><?php echo htmlspecialchars($entity->getPhotoUrlMedium(), ENT_COMPAT, 'utf-8') ?></photourl>
  <connections>
    <?php foreach ($entity->getAllConnections() as $e): ?>
      <conn type="<?php echo htmlspecialchars($e['EntityType']['id'], ENT_COMPAT, 'utf-8') ?>" num="<?php echo htmlspecialchars($e['id'], ENT_COMPAT, 'utf-8') ?>" />
    <?php endforeach ?>
  </connections>
</entity>