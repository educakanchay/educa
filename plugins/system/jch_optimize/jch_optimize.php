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
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

if (!defined('JCH_PLUGIN_DIR'))
{
        define('JCH_PLUGIN_DIR', dirname(__FILE__) . '/');
}

include_once dirname(__FILE__) . '/jchoptimize/loader.php';

class plgSystemJCH_Optimize extends JPlugin
{

        /**
         * 
         * @return boolean
         * @throws Exception
         */
        public function onAfterRender()
        {
                if(JDEBUG && $this->params->get('debug', 0))
                {
                        global $_PROFILER;
                        
                        $_PROFILER->mark('beforeOnAfterRender plgSystem (JCH Optimize)');
                }
                
                if ((JFactory::getApplication()->getName() != 'site') || (JFactory::getDocument()->getType() != 'html')
                        || (JFactory::getApplication()->input->get('jchbackend', '', 'int') == 1)
                        || (JFactory::getConfig()->get('offline') && JFactory::getUser()->guest)
                        || $this->isEditorLoaded())
                {
                        return FALSE;
                }

                if ($this->params->get('log', 0))
                {
                        error_reporting(E_ALL & ~E_NOTICE);
                }

                if (version_compare(JVERSION, '3.2.3', '>='))
                {
                        $oApp  = JFactory::getApplication();
                        $sHtml = $oApp->getBody();
                }
                else
                {
                        $sHtml = JResponse::getBody();
                }

                if (JFactory::getApplication()->input->get('jchbackend') == '2')
                {
                        echo $sHtml;
                        while (@ob_end_flush());
                        exit;
                }

                try
                {
                        if (version_compare(PHP_VERSION, '5.3.0', '<'))
                        {
                                throw new Exception(JText::_('PHP Version less than 5.3.0. Exiting plugin...'));
                        }

                        $sOptimizedHtml = JchOptimize::optimize($this->params, $sHtml);
                }
                catch (Exception $ex)
                {
                        if ($this->params->get('log', 0))
                        {
                                jimport('joomla.log.log');
                                JLog::addLogger(
                                        array(
                                        'text_file' => 'plg_jch_optimize.errors.php'), JLog::ALL, 'jch-optimize'
                                );
                                JLog::add(JText::_($ex->getMessage()), JLog::WARNING, 'jch-optimize');
                        }

                        $sOptimizedHtml = $sHtml;
                }

                if (version_compare(JVERSION, '3.2.3', '>='))
                {
                        $oApp->setBody($sOptimizedHtml);
                }
                else
                {
                        JResponse::setBody($sOptimizedHtml);
                }
                
                if(JDEBUG && $this->params->get('debug', 0))
                {
                        $_PROFILER->mark('afterOnAfterRender plgSystem (JCH Optimize)');
                }
        }

        /**
         * Gets the name of the current Editor
         * 
         * @staticvar string $sEditor
         * @return string
         */
        protected function isEditorLoaded()
        {
                $sEditor = JFactory::getUser()->getParam('editor');
                $sEditor = !isset($sEditor) ? JFactory::getConfig()->get('editor') : $sEditor;

                $sEditorClass = 'plgEditor' . $sEditor;
                
                return class_exists($sEditorClass);
        }

        
}

//function jchprint($variable, $name = '', $exit = FALSE, $silent = FALSE)
//{
//        if ($silent) echo '<script> ';
//        
//        echo '<pre>';
//        
//        if ($name != '')
//        {
//                echo $name . ' = ';
//        }
//        
//        if ($silent) {$variable = str_replace ('</script>', '</+script>', $variable);}
//        print_r($variable);
//        
//        echo '</pre>';
//        
//        if ($silent) echo ' </script>';
//        
//        if ($exit)
//        {
//                exit();
//        }
//}