<?php
/**
 * @file      AblePolecat-View/usr/src/Response.php
 * @brief     Base class for all HTTP responses.
 *
 * @author    Karl Kuhrman
 * @copyright 2015 [GPL V2] Karl Kuhrman
 */

require_once(implode(DIRECTORY_SEPARATOR, array(ABLE_POLECAT_SRC, 'Path.php')));
require_once(implode(DIRECTORY_SEPARATOR, array(ABLE_POLECAT_CORE, 'Component', 'Form.php')));
require_once(implode(DIRECTORY_SEPARATOR, array(ABLE_POLECAT_CORE, 'Message', 'Response', 'Xhtml', 'Tpl.php')));

class AblePolecatView_Response extends AblePolecat_Message_Response_Xhtml_Tpl {
  
  /**
   * Registry article constants.
   */
  const UUID = '41855f13-3ae8-11e5-8795-e0699576cabe';
  const NAME = 'AblePolecatView_Response';
  
  //
  // ID attribute names for some top-level child elements of the <BODY> element
  //
  const DIV_ID_HEADER          = 'header';
  const DIV_ID_BREADCRUMBS     = 'breadcrumbs';
  const DIV_ID_CONTENT         = 'content';
  const DIV_ID_FOOTER          = 'footer';
  const DIV_ID_FINEPRINT       = 'fineprint';
  
  /********************************************************************************
   * Implementation of AblePolecat_DynamicObjectInterface.
   ********************************************************************************/
  
  /**
   * Create a concrete instance of AblePolecat_MessageInterface.
   *
   * @return AblePolecat_MessageInterface Concrete instance of message or NULL.
   */
  public static function create() {    
    $Response = self::setConcreteInstance(new AblePolecatView_Response());
    $ArgsList = self::unmarshallArgsList(__FUNCTION__, func_get_args());
    return self::getConcreteInstance();
  }
  
  /********************************************************************************
   * Implementation of AblePolecat_Message_ResponseInterface.
   ********************************************************************************/
  
  /**
   * @param AblePolecat_ResourceInterface $Resource
   */
  // public function setEntityBody(AblePolecat_ResourceInterface $Resource) {
  // }
  
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
    //
    // <head>
    //
    $templateName = $this->getRepresentationTemplateName(self::ELEMENT_HEAD);
    $templateSearchPaths = $this->getTemplateSearchPaths($templateName);
    $domDirectives = array(
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_OP => AblePolecat_Dom::DOM_FRAGMENT_OP_REPLACE,
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_FRAGMENT_PARENT => self::ELEMENT_HTML,
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_REPLACE_NODE => AblePolecat_Dom::getElementsByTagName($Document, self::ELEMENT_HEAD, 0)
    );
    $Element = AblePolecat_Dom::loadTemplateFragment(
      $Document,
      $templateSearchPaths,
      $domDirectives
    );
    
    //
    // Append top-of-fold elements to this...
    //
    $elementOuterWrapper = AblePolecat_Dom::getElementById($Document, 'OuterWrapper');
    $domDirectives = array(
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_OP => AblePolecat_Dom::DOM_FRAGMENT_OP_APPEND,
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_FRAGMENT_PARENT => self::ELEMENT_BODY,
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_DOCUMENT_PARENT => $elementOuterWrapper
    );
    
    //
    // <div id="header">OuterWrapper
    //
    $templateName = $this->getRepresentationTemplateName(self::DIV_ID_HEADER);
    $templateSearchPaths = $this->getTemplateSearchPaths($templateName);
    $Element = AblePolecat_Dom::loadTemplateFragment(
      $Document,
      $templateSearchPaths,
      $domDirectives
    );
    
    //
    // <div id="breadcrumbs">
    //
    $templateName = $this->getRepresentationTemplateName(self::DIV_ID_BREADCRUMBS);
    $templateSearchPaths = $this->getTemplateSearchPaths($templateName);
    $Element = AblePolecat_Dom::loadTemplateFragment(
      $Document,
      $templateSearchPaths,
      $domDirectives
    );
    
    //
    // <div id="content">
    //
    $templateName = $this->getRepresentationTemplateName(self::DIV_ID_CONTENT);
    $templateSearchPaths = $this->getTemplateSearchPaths($templateName);
    $Element = AblePolecat_Dom::loadTemplateFragment(
      $Document,
      $templateSearchPaths,
      $domDirectives
    );
    
    //
    // <div class="push">
    //
    $pushDiv = $Document->createElement('div');
    $pushDiv->setAttribute('class', 'push');
    $elementOuterWrapper->appendChild($pushDiv);
    
    //
    // The rest gets appended to <body>
    //
    $elementBody = AblePolecat_Dom::getElementsByTagName($Document, self::ELEMENT_BODY, 0);
    $domDirectives = array(
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_OP => AblePolecat_Dom::DOM_FRAGMENT_OP_APPEND,
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_FRAGMENT_PARENT => self::ELEMENT_BODY,
      AblePolecat_Dom::DOM_DIRECTIVE_KEY_DOCUMENT_PARENT => $elementBody
    );
    
    //
    // <div id="footer">
    //
    $templateName = $this->getRepresentationTemplateName(self::DIV_ID_FOOTER);
    $templateSearchPaths = $this->getTemplateSearchPaths($templateName);
    $Element = AblePolecat_Dom::loadTemplateFragment(
      $Document,
      $templateSearchPaths,
      $domDirectives
    );
    
    //
    // <div id="fineprint">
    //
    $templateName = $this->getRepresentationTemplateName(self::DIV_ID_FINEPRINT);
    $templateSearchPaths = $this->getTemplateSearchPaths($templateName);
    $Element = AblePolecat_Dom::loadTemplateFragment(
      $Document,
      $templateSearchPaths,
      $domDirectives
    );
    
    //
    // Search form.
    //
    $Resource = $this->getResource();
    $ComponentRegistration = AblePolecat_Registry_Entry_DomNode_Component::fetch('8d9af272-f406-11e4-b9b2-0050569e00a2');
    $searchComponent = AblePolecat_Component_Form::create($ComponentRegistration, $Resource);
    $this->setComponent('8d9af272-f406-11e4-b9b2-0050569e00a2', $searchComponent);
    
    return parent::preprocessEntityBody($Document);
  }
  
  /**
   * Post processing of entity body is final edit. Typically simple text substitutions.
   *
   * @param $string entityBody
   *
   * @return string.
   */
  protected function postProcessEntityBody($entityBody) {
    
    //
    // @todo: Standard string substitutions should probably be stored in db or conf file
    //
    $this->setSubstitutionMarker('{!AblePolecatView.Title}', 'AblePolecat-View');
    $this->setSubstitutionMarker('{!AblePolecatView.baseUrl}', AblePolecatView_Path::getBaseUrl());
    $this->setSubstitutionMarker('{!AblePolecatView.themeUrl}', AblePolecatView_Path::getThemeUrl());
    
    return parent::postProcessEntityBody($entityBody);
  }
  
  /**
   * Default options for full path of a given template fragment file.
   *
   * This function generates an array of possible paths for the file containing
   * the given template fragment. Best practice is to reuse templates wherever 
   * possible and thus create specific templates for resources only when an 
   * override of the default is required for that resource.
   *
   * Accordingly, using the template name 'content' (file name content.tpl), and 
   * two resources, location/chicago/north and location/chicago/south as example,
   * assume the first resource will use the same template as all other location/..
   * resources but the second requires some specific override of the template.
   * The first would be saved at location/content.tpl but the second would be saved 
   * at location/chicago/south/content.tpl.
   *
   * But this function does not bother with verifying if file exists, only creating an
   * array of possible paths from most specific to most general. So the list for the
   * location/chicago/south resource in the example above would be:
   * - location/chicago/south/content.tpl
   * - location/chicago/content.tpl
   * - location/content.tpl
   * - default/content.tpl
   *
   * @param string $templateName Name of template fragment (e.g. head, content, etc).
   *
   * @return Array Full path options for template given by $templateName.
   * @see AblePolecat_Dom::loadTemplateFragment().
   */
  protected function getTemplateSearchPaths($templateName) {
    
    $resourcePath = explode(URI_SLASH, $this->getResourceName());
    $themeDirectoryFullPath = AblePolecatView_Path::getThemeDirectoryFullPath();
    $templateSearchPaths = array();
    
    //
    // Begin with most specific path and traverse backward to default.
    //
    $moreElements = count($resourcePath);
    while ($moreElements) {
      $relativePath = implode(DIRECTORY_SEPARATOR, $resourcePath);
      $templateSearchPaths[] = implode(DIRECTORY_SEPARATOR, array($themeDirectoryFullPath, 'template', $relativePath, $templateName . '.tpl'));
      $lastElement = array_pop($resourcePath);
      $moreElements = count($resourcePath);
    }
    $templateSearchPaths[] = implode(DIRECTORY_SEPARATOR, array($themeDirectoryFullPath, 'template', 'default', $templateName . '.tpl'));
    
    return $templateSearchPaths;
  }
  
  /**
   * This function supports overriding one of the default template names. 
   * For example, the designer may wish to use a different template for 
   * each SObject record type. In such case, designer might create a template
   * for the content area and name it content_[RecordTypeName], where the 
   * latter part of the template name corresponds to the name of the 
   * SObject record type.
   *
   * @param string $templateName Name of template fragment (e.g. head, content, etc).
   *
   * @return string.
   */
  protected function getRepresentationTemplateName($templateName) {
    return $templateName;
  }
}