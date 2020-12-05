<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * phpMyAdmin sample configuration, you can use it as base for
 * manual configuration. For easier setup you can use setup/
 *
 * All directives are explained in documentation in the doc/ folder
 * or at <https://docs.phpmyadmin.net/>.
 *
 * @package PhpMyAdmin
 */


/*
*  Set the number of seconds a script is allowed to run. 
*  If seconds is set to zero, no time limit is imposed. 
*  This setting is used while importing/exporting dump files but has no effect when PHP is running in safe mode.
*/

$cfg['ExecTimeLimit'] = 1800;

// Default is -1
//$cfg['MemoryLimit'] = 2048M;
