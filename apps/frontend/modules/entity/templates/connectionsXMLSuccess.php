<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>


<connections>
  <?php foreach ($facts as $f): ?>
    <connection id="<?php echo htmlspecialchars($f['id'], ENT_COMPAT, 'utf-8') ?>" type="<?php echo htmlspecialchars($f['FactType']['id'], ENT_COMPAT, 'utf-8') ?>">
      <entity name="<?php echo htmlspecialchars($f['Entity']['name'], ENT_COMPAT, 'utf-8') ?>" id="<?php echo htmlspecialchars($f['Entity']['id'], ENT_COMPAT, 'utf-8') ?>" t="<?php echo htmlspecialchars($f['Entity']['EntityType']['id'], ENT_COMPAT, 'utf-8') ?>">
        <photourl><?php echo htmlspecialchars($f['Entity']->getPhotoUrlMedium(), ENT_COMPAT, 'utf-8') ?></photourl>
        <position><?php echo htmlspecialchars($f['Entity']['subtitle'], ENT_COMPAT, 'utf-8') ?></position>
      </entity>
      <entity name="<?php echo htmlspecialchars($f['RelatedEntity']['name'], ENT_COMPAT, 'utf-8') ?>" id="<?php echo htmlspecialchars($f['RelatedEntity']['id'], ENT_COMPAT, 'utf-8') ?>" t="<?php echo htmlspecialchars($f['RelatedEntity']['EntityType']['id'], ENT_COMPAT, 'utf-8') ?>">
        <photourl><?php echo htmlspecialchars($f['RelatedEntity']->getPhotoUrlMedium(), ENT_COMPAT, 'utf-8') ?></photourl>
        <position><?php echo htmlspecialchars($f['RelatedEntity']['subtitle'], ENT_COMPAT, 'utf-8') ?></position>
      </entity>
      <description><?php echo htmlspecialchars($f['title'], ENT_COMPAT, 'utf-8') ?>
        <?php if ($f['start']): echo date_create($f['start'])->format('Y'); endif; ?><?php if ($f['start'] || $f['end']): ?> – <?php endif ?><?php if ($f['end']): echo date_create($f['end'])->format('Y'); elseif ($f['start']): echo '?'; endif; ?>
        </description> 
    </connection> 
  <?php endforeach ?>


</connections>