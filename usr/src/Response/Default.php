<?php
/**
 * @file      AblePolecat-View/usr/src/Response/Default.php
 * @brief     Default HTTP response class.
 *
 * @author    Karl Kuhrman
 * @copyright 2015 [GPL V2] Karl Kuhrman
 */
 
require_once(ABLE_POLECAT_SRC . DIRECTORY_SEPARATOR . 'Response.php');

class AblePolecatView_Response_Default extends AblePolecatView_Response {
  
  /**
   * Registry article constants.
   */
  const UUID = 'e8013ff8-bd27-11e4-a12d-0050569e00a2';
  const NAME = 'AblePolecatView_Response_Default';
  
  /********************************************************************************
   * Implementation of AblePolecat_DynamicObjectInterface.
   ********************************************************************************/
  
  /**
   * Create a concrete instance of AblePolecat_MessageInterface.
   *
   * @return AblePolecat_MessageInterface Concrete instance of message or NULL.
   */
  public static function create() {    
    $Response = self::setConcreteInstance(new AblePolecatView_Response_Default());
    $ArgsList = self::unmarshallArgsList(__FUNCTION__, func_get_args());
    return self::getConcreteInstance();
  }
  
  /********************************************************************************
   * Helper functions.
   ********************************************************************************/
  
  /**
   * Preprocessing DOM document allows sub-classes to insert/append additional elements.
   * 
   * This function is called after DOM document has been created but before it is set.
   *
   * @param DOMDocument $Document
   *
   * @return DOMDocument $Document
   */
  protected function preprocessEntityBody(DOMDocument $Document) {    
    return parent::preprocessEntityBody($Document);
  }
}