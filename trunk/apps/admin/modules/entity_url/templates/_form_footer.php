<hr>

<h2>Help</h2>
<dl>
  <dt>Entity id</dt>
  <dd><p>Use the "Entity id" field to find the entity you're after, then fill in the URL of the site you're linking, and the title of the link. So far so obvious.</p></dd>
  
  <dt>URL Type</dt>
  <dd><p>The <strong>urltype</strong> field defines the type of site you're linking to. Various scripts and tasks associated with the database will do things with certain urltypes - for example the twfy:import task checks whether a urltype of <code>theyworkforyou</code> exists for the person it's looking at, and skips the entry (other tasks then use it to request more information about that person using the TWFY API).</p>
      <p>Another useful urltype is <code>wikipedia</code>. We can use wikipedia URLs to query both wikipedia itself, and DBPedia to do further processing. Some other common types have been added.</p></dd>

  <dt>Foreign id</dt>
  <dd><p>The <strong>foreign id</strong> field is useful for scripts that process these URLs. This is the unique identifier on the foreign site, and we can use it when calling remote APIs to gather more information. For example, TheyWorkForYou-type URLs have the foreign id set to TWFY's "person id". This field is usually optional, although this depends on the urltype.</p></dd>
  
  <dt>Verifications</dt>
  <dd><p>Entity URLs need to be verified by at least one person before they're considered trustworthy. Some automated tasks create Entity URLs which then need to be checked by eye to be sure they're correct, but this also prevents pranksters or honest mistakes. At the bottom of the page, a form shows the first URL Verification - if none exists, this form is blank and when you save it creates a new one.</p></dd>

</dl>