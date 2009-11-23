<?php

require_once(dirname(__FILE__).'/vendor/Sanitizer.php');
require_once(dirname(__FILE__).'/vendor/normal/UtfNormalUtil.php');


class tuiWikiUrl
{

  // Used for creating URL slugs, with the Wikipedia (MediaWiki) method.
 public static function urlize($text)
 {
   $text = str_replace('/','_', $text);
   $text = str_replace('?','_', $text);
   return str_replace(' ', '_', trim(Sanitizer::decodeCharReferences( $text ) ));
 }

}