<dl>

  <dt>Title</dt>
  <dd><?php echo htmlspecialchars($story['title'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Author</dt>
  <dd><?php echo htmlspecialchars($story['Creator']['username'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Revision number</dt>
  <dd><?php echo htmlspecialchars($story['version'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Dates</dt>
  <dd>Created: <?php echo htmlspecialchars($story['created_at'], ENT_COMPAT, 'utf-8') ?></dd>
  <dd>Updated: <?php echo htmlspecialchars($story['updated_at'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Rating</dt>
  <dd><?php echo htmlspecialchars($story['Rating']['average_vote'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Subtitle</dt>
  <dd><?php echo htmlspecialchars($story['subtitle'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Teaser</dt>
  <dd><?php echo htmlspecialchars($story['teaser'], ENT_COMPAT, 'utf-8') ?></dd>

  <dt>Body</dt>
  <dd><?php echo foaf_story_filter($story['description'], 'story'.$story['id'].'version-'.$story['version']) ?></dd>

  <dt>Comments</dt>
  <dd>TODO</dd>

  <dt>Comment Form</dt>
  <dd>TODO</dd>

  <dt>Story Column</dt>
  <dd>Note: final story column display is more complicated than this (not much, but it shouldn't be showing every entity, and sometimes the primary/related order is reversed, and that's not shown here)
    <ul>
    <?php foreach ($story['StoryFacts'] as $sf): ?>
      <li>Entity name: <strong><?php echo htmlspecialchars($sf['Fact']['Entity']['name'], ENT_COMPAT, 'utf-8') ?></strong><br>
        Entity short-desc: TODO<br>
        Entity bio: <?php echo htmlspecialchars($sf['Fact']['Entity']['description'], ENT_COMPAT, 'utf-8') ?><br>
        Entity link: TODO<br>
        Entity map link: TODO<br>
        Entity story list: TODO<br>
        linking text: <strong><?php echo htmlspecialchars($sf['description'], ENT_COMPAT, 'utf-8') ?></strong><br>
        Related entity: <strong><?php echo htmlspecialchars($sf['Fact']['RelatedEntity']['name'], ENT_COMPAT, 'utf-8') ?></strong><br>
        Related entity short-desc: TODO<br>
        Related entity bio: <?php echo htmlspecialchars($sf['Fact']['RelatedEntity']['description'], ENT_COMPAT, 'utf-8') ?><br>
        Related entity link: TODO<br>
        Related entity map link: TODO<br>
        Related entity story list: TODO<br>
        </li>
    
    <?php endforeach ?>
    </ul>
  </dd>

  <dt>Links</dt>
  <dd>Suggest a story: TODO</dd>
  <dd>Report a mistake: TODO</dd>


</dl>