<?php

require_once(dirname(__FILE__).'/vendor/htmLawed.php');


class tuiHTMLFilter
{

  static function clean($text)
  {

    $spec   = null;
    $config = array('comment'           => 1,  // Remove comments
                    'valid_xhtml'       => 1, 
                    'css_expression'    => 0, // Remove CSS expressions
                    'safe'              => 1, // Disallow applet, embed, iframe, object, script
                    'keep_bad'          => 1, // Remove bad tags outright
                    'named_entity'      => 0,
                    'no_deprecated_atr' => 2, // <a name> should be converted
                    // 'schemes'           => '*: http, https', // Restrict URL schemes
                    'unique_ids'        => 'usr_', // Prefix duplicate ids
                    'balance'           => 2,
                    'elements'          => '* -script -applet -embed -object -iframe-rb -rbc -rp -rt -rtc -ruby -form -input -select -button -option -optgroup -legend -fieldset -bdo -noscript -isindex -map'
      );
      
    return htmlawed($text, $config, $spec);
  }


  static function deepClean($text)
  {

    $spec   = null;
    $config = array('comment'           => 1,  // Remove comments
                    'valid_xhtml'       => 1, 
                    'css_expression'    => 0, // Remove CSS expressions
                    'safe'              => 1, // Disallow applet, embed, iframe, object, script
                    'keep_bad'          => 1, // Remove bad tags outright
                    'named_entity'      => 0,
                    'no_deprecated_atr' => 2, // <a name> should be converted
                    'schemes'           => '*: http, https', // Restrict URL schemes
                    'unique_ids'        => 'usr_', // Prefix duplicate ids
                    'make_tag_strict'   => 1,
                    'balance'           => 2,
                    'elements'          => 'a, abbr, b, blockquote, br, cite, code, del, em, hr, i, ins, li, ol, p, q, strong, sub, sup, ul, u'
      );
    
    return htmlawed($text, $config, $spec);
  }


  

}