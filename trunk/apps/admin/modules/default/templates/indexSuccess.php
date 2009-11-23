<div class="container">
  <h1>C4FOAF raw editor</h1>
  
  <hr>
  
  <div class="span-8">
    <h2>Things</h2>
    <dl>
      <dt><?php echo link_to('Home page content', 'home/index') ?></dt>
      <dd><p>Create and edit homepage content</p></dd>

      <dt><?php echo link_to('Entities', 'entity/index') ?></dt>
      <dd><p>Add/edit people, schools, etc</p></dd>

      <dt><?php echo link_to('Facts', 'fact/index?') ?></dt>
      <dd><p>Statements about entities.</p></dd>

      <dt><?php echo link_to('Stories/Collections/Groups', 'story/index') ?></dt>
      <dd><p>A collection of facts and the people they're about, linked by a common description. Can be private or shared.</p></dd>

      <dt><?php echo link_to('Story columns', 'story_edit/index') ?></dt>
      <dd><p>Illustrating a story by joining Facts about the people and things involved.</p> </dd>
      
      <dt><?php echo link_to('Messages', 'contact_messages/index') ?></dt>
      <dd><p>Feedback from users. General enquiries, story suggestions and error reports.</p> </dd>

    </dl>
  </div>
  
  <div class="span-8">
    <h2>Things that support Things</h2>
    <dl>
      <dt><?php echo link_to('Aliases', 'entity_alias/index') ?></dt>
      <dd><p>Some things have different names.</p></dd>

      <dt>Disambiguation</dt>
      <dd><p>Some things have the same name but are actually distinct.</p></dd>

      <dt><?php echo link_to('Entity URLs', 'entity_url/index?') ?></dt>
      <dd><p>Web pages related to an entity, e.g. Wikipedia page.</p></dd>
      
      <dt><?php echo link_to('Sources', 'fact_source/index?') ?></dt>
      <dd><p>URLs that support or refute Facts</p></dd>

    </dl>
  </div>
  

  <div class="span-8 last">
    <h2>Metadata about things</h2>
    <dl>
      <dt><?php echo link_to('Entity URL verifications', 'entity_url_verified/index') ?></dt>
      <dd><p>Validating URL quality/applicability.</p></dd>
      
      <dt><?php echo link_to('Fact comments', 'fact_comment/index?') ?></dt>
      <dd><p>Moderation for Fact discussion.</p></dd>

      <dt><?php echo link_to('Source verifications', 'fact_source_verified/index?') ?></dt>
      <dd><p>Scoring sources up or down.</p></dd>
      
      <dt><?php echo link_to('Story comments', 'story_comment/index?') ?></dt>
      <dd><p>Moderation of Story discussion.</p></dd>
    </dl>
  </div>
  
  <hr>
  
  <div class="span-8">
    <h2>Architecture</h2>
    <div class="error">Be super-careful with these. Great way to delete the whole database.</div>
    
    <dl>
      <dt><?php echo link_to('Entity Types', 'entity_type/index?') ?></dt>
      <dd><p>Kinds of entity (e.g. Person, Club, School, Company)</p></dd>

      <dt><?php echo link_to('Fact Types', 'fact_type/index?') ?></dt>
      <dd><p>Kinds of fact (e.g. Historical, Geographical, Legal)</p></dd>

      <dt><?php echo link_to('Source types', 'source_type/index?') ?></dt>
      <dd><p>Kinds of link (e.g. Public record, blog, editorial, researched article)</p></dd>

      <dt><?php echo link_to('Story types', 'story_type/index?') ?></dt>
      <dd><p>Kinds of collection (e.g., Story, Editorial, Collection)</p></dd>
      
    </dl>
    
    
  </div>
  
  <div class="span-16 last">
    <h2>Quick Start</h2>

    <p>A typical example workflow is this:</p>
    <ol>
      <li>Add one or more Entities (people, companies, schools, etc). Don't forget to search for duplicates first, and fill in your username in the "Created By" field.</li>
      <li>Use the Fact editor to add information about each Entity - each fact should have at least one supporting source, so use the embedded form. You can use the Fact Source editor to add more sources later. Facts that link Entities should have the second Entity in the "related entity" field, e.g. if the fact is that Boris Johnson went to Eton, then put Eton College in the related entity field. Add start and end dates where possible, but only when they're accurate. Unfortunately the forms don't yet allow partial dates (like 1980, or March 1980).</li>
      <li>Create a story with the Story/Group/Collection editor. Enter some explanatory copy to accompany it and make sure you set the Created By to yourself.</li>
      <li>Use the Story Column editor to draw in the facts that support your story; start by searching for the entity, then pick the fact you're after. Back at the story column view, write linking text and make sure the "The story so far" reads well - you may have to change the order of facts, or switch the entities around.</li>
    </ol>

  </div>
  
</div>