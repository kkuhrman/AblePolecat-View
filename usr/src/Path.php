<?php
/**
 * @file      AblePolecat-View/usr/src/Path.php
 * @brief     Helper class for path name.
 *
 * @author    Karl Kuhrman
 * @copyright 2015 [GPL V2] Karl Kuhrman
 */
 
class AblePolecatView_Path {
  
  /**
   * Registry article constants.
   */
  const UUID = '19c648f3-3ae8-11e5-8795-e0699576cabe';
  const NAME = 'AblePolecatView_Path';
  
  /**
   * @return string URL to project root on web (location of index.php).
   */
  public static function getBaseUrl() {
    $baseUrl = AblePolecat_Host::getRequest()->getBaseUrl(FALSE);
    return $baseUrl;
  }
  
  /**
   * @return string Name of directory of theme files (.js, .css. tpl, etc).
   */
  public static function getThemeDirectoryFullPath() {
    $themeName = self::getThemeName();
    return $templateSearchPaths[] = implode(DIRECTORY_SEPARATOR, array(ABLE_POLECAT_THEME, $themeName));
  }
  
  /**
   * @return name/id of theme.
   */
  public static function getThemeName() {
    //
    // @todo: this is a place-holder for future flexibility...
    //
    return 'default';
  }
  
  /**
   * @return string URL of theme files (assets, scripts, style sheets etc.)
   */
  public static function getThemeUrl() {
    $themeUrl = implode(URI_SLASH, array(self::getBaseUrl(), 'theme', self::getThemeName()));
    return $themeUrl;
  }
}