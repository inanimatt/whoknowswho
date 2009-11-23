<?php

/* mobileDetectFilter performs a lookup of the HTTP User Agent against the
 * WURFL mobile browser capability database, retrieves a list of capabilities
 * and matches them to a compliant "platform", as defined in a configuration 
 * file. Platforms are collections of required capabilities - 
 * mobileDetectFilter chooses the first platform whose requirements are 
 * entirely satisfied by the user agent. The platform name is stored in the
 * symfony user object, where it can be accessed by the actions or views in
 * your code. An alternative view-class is also provided, which selects a
 * different output template if a platform variant exists.
 */



class tuiExternalLinkFilter extends sfFilter
{

  public function execute($filterChain)
  {
    
    // execute this filter only once
    if ($this->isFirstCall() && $this->getParameter('register_css', true))
    {
      // register our css
      $response = sfContext::getInstance()->getResponse()->addStylesheet('/tuiExternalLinkPlugin/css/extlinks');
    }
    
    
    
    // Execute next filter
    $filterChain->execute();


    
    // Only affect the output of HTML pages
    $response = $this->getContext()->getResponse();
    $contentType = $response->getContentType();


    // don't add debug toolbar:
    // * if 304
    // * if not rendering to the client
    // * if HTTP headers only
    $context    = $this->getContext();
    $controller = $context->getController();
    if (
      strpos($response->getContentType(), 'html') === false ||
      $response->getStatusCode() == 304 ||
      $controller->getRenderMode() != sfView::RENDER_CLIENT ||
      $response->isHeaderOnly()
    )
    {
      return;
    }

    // add a token to every form in the response content
    $response->setContent(preg_replace_callback('#(<a ([^>]+))#i', array($this,'addClass'), $response->getContent()));
    
    
  }
  
  
  public function addClass($matches) {
    $class = $this->getParameter('class','extURL');
 
    $link_tag = $matches[0];
    
    if (stripos($link_tag, 'href="http://') || stripos($link_tag, 'href="https://')) {
      if ($pos = stripos($link_tag, 'class="')) {
        $link_tag = str_replace('class="', 'class="'.$class.' ', $link_tag);
      } else {
        $link_tag = $link_tag . ' class="'.$class.'"';
      }

      if ($this->getParameter('new_window', false)) {
        $link_tag .= ' target="_blank"';
      }
    }


    return $link_tag;
  }
  

}
