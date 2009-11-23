<?php

class Addinitialhomepage extends Doctrine_Migration_Base
{
  public function up()
  {
    
    $h = new Home;
    $h['is_active'] = 1;
    $h['feature_html'] = <<<EOS
      <div class="image">
          <img src="/static/images/site/homepage_boris_dave.jpg" width="645" height="337" alt="When Boris met Dave">
      </div>

      <h4 class="sIFR-c4">Stories</h4>
      <h5 class="sIFR-c4">When Boris met Dave</h5>
      <a href="/frontend_dev.php/stories" class="stories">View all stories</a>
      <p class="connections">View their connections</p>

      <div class="info clearfix">
        <div class="left-side">
          <a href="/frontend_dev.php/people/Boris_Johnson" class="name">Boris Johnson</a>
          <p>Mayor of London</p>
          <a href="/frontend_dev.php/people/Boris_Johnson/map" class="number">23 connections</a>
        </div>
        <div class="right-side">
          <a href="/frontend_dev.php/people/David_Cameron" class="name">David Cameron</a>
            <p>Tory Party Leader</p>
            <a href="/frontend_dev.php/people/David_Cameron/map" class="number">65 connections</a>
        </div>
      </div>
EOS;
    
    $h['feature_copy_intro'] = <<<EOS
      <p>A photo shows 10 teenagers standing in an Oxford quadrangle wearing exquisitely tailored tailcoats, ready for a night of fine dining and drinking.</p>

      <p>Among them are two men who would go on to be the most powerful Conservative politicians in the country: Boris Johnson and David Cameron, respectively the mayor of London and the man many think will be the next prime minister.</p>

      <p>But how has their shared past at Eton and Oxford, where they were both members of elite drinking society the Bullingdon Club, prepared them for high office in 21st century Britain?</p>
EOS;

    $h['feature_copy_extended'] = <<<EOS
      <p>The director of When Boris Met Dave, John Dower, has explained that the programme's origins grew out of the famous 1987 photograph of the Bullingdon Club. Channel 4 recreated the image using actors. But what is it about the picture that fascinates people?</p>

      <p>John Dower says: "It just looks like a snapshot from Britain's imperial past. It is, in fact, taken in the mid-1980s, a time more synonymous with Wham!, Beverley Hills Cop and the miners' strike.</p>

      <p>"These guys are teenagers, and they're dressed in these very expensive-looking tailcoats and bow ties. They look very elegant and arrogant. They don't look like they have the insecurities of teenage boys, and they're all posing very defiantly in the picture.</p>

      <p>"So you think this belongs in another era, and then you look closely and you think: 'That blond sitting at the front - that's the mayor of London. Back row, second from the right, there's this very pretty boy staring dreamily into the distance - that's David Cameron, he'll probably be the next leader of the country.'"</p>

      <p>When Boris Met Dave will be shown on Channel 4 on Saturday 14th November at 8pm.</p>
EOS;
    
    $h['callout_html'] = <<<EOS
      <div class="image">
        <a href="http://www.channel4.com/programmes/when-boris-met-dave" class="external-url" target="_blank"><img src="/static/images/site/watch_boris_met_dave.jpg" width="314" height="200" alt="Watch when Boris met dave"></a>
      </div>
EOS;
    
    $h['story1_id'] = 9;
    $h['story2_id'] = 13;
    $h['story3_id'] = 10;
    $h['story4_id'] = 12;
    
    $h['story1_image_url'] = '/static/images/story_images/story_000004.jpg';
    $h['story2_image_url'] = '/static/images/story_images/story_000003.jpg';
    $h['story3_image_url'] = '/static/images/story_images/story_000002.jpg';
    $h['story4_image_url'] = '/static/images/story_images/story_000001.jpg';
    
    $h->save();
  }

  public function down()
  {
  }
}
