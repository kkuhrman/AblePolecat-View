<?php
/**
 * @file      AblePolecat-View/var/www/htdocs/index.php
 * @brief     All requests are routed through index.php.
 *
 * @author    Karl Kuhrman
 * @copyright 2015 [GPL V2] Karl Kuhrman
 */

/**
 * Path settings.
 */
include_once('path.config');

/**
 * Route HTTP request.
 */
require_once(implode(DIRECTORY_SEPARATOR, array(ABLE_POLECAT_CORE, 'Host.php')));
AblePolecat_Host::routeRequest();