<?php

/**
 * JCH Optimize - Joomla! plugin to aggregate and minify external resources for
 * optmized downloads
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2010 Samuel Marshall
 * @license GNU/GPLv3, See LICENSE file
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 *
 * This plugin, inspired by CssJsCompress <http://www.joomlatags.org>, was
 * created in March 2010 and includes other copyrighted works. See individual
 * files for details.
 */
defined('_JCH_EXEC') or die('Restricted access');

/**
 * 
 * 
 */
class JchOptimizeLogger
{
        /**
         * 
         * @param type $sMessage
         * @param JchPlatformSettings $params
         * @param type $sCategory
         */
        public static function log($sMessage, JchPlatformSettings $params, $sCategory = 'jch-optimize')
        {
                if ($params->get('log', 0))
                {
                        JchPlatformUtility::log($sMessage, $sCategory);
                }
        }
        
        /**
         * 
         * @param type $variable
         * @param type $name
         */
        public static function debug($variable, $name='')
        {
                $sMessage = $name != '' ? "$name = '" . $variable . "'" : $variable;
                
                JchPlatformUtility::log($sMessage, 'jch-optimize');
        }

}
