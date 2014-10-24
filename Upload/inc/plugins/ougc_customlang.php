<?php

/***************************************************************************
 *
 *	OUGC Custom Language plugin (/inc/plugins/ougc_customlang.php)
 *	Author: Omar Gonzalez
 *	Copyright: © 2012 - 2014 Omar Gonzalez
 *
 *	Website: http://omarg.me
 *
 *	Loads an custom language file that is not updated during core upgrades.
 *
 ***************************************************************************
 
****************************************************************************
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
****************************************************************************/

// Die if IN_MYBB is not defined, for security reasons.
defined('IN_MYBB') or die('This file cannot be accessed directly.');

// Add our hooks
if(!defined('IN_ADMINCP'))
{
	$plugins->add_hook('global_start', 'ougc_customlang');
	$plugins->add_hook('xmlhttp', 'ougc_customlang');
}

// Plugin API
function ougc_customlang_info()
{
	return array(
		'name'          => 'OUGC Custom Language',
		'description'   => 'Loads an custom language file that is not updated during core upgrades.',
		'website'		=> 'http://mods.mybb.com/view/ougc-custom-language',
		'author'		=> 'Omar G.',
		'authorsite'	=> 'http://omarg.me',
		'version'		=> '1.0',
		'versioncode'	=> 1000,
		'compatibility'	=> '18*'
	);
}

// _activate function
function ougc_customlang_activate()
{
	global $cache;

	// Insert version code into cache
	$plugins = $cache->read('ougc_plugins');
	if(!$plugins)
	{
		$plugins = array();
	}

	$info = ougc_customlang_info();

	$plugins['customlang'] = $info['versioncode'];
	$cache->update('ougc_plugins', $plugins);
}

// _is_installed function
function ougc_customlang_is_installed()
{
	global $cache;
	$plugins = $cache->read('ougc_plugins');

	return isset($plugins['customlang']);
}

// _uninstall function
function ougc_customlang_uninstall()
{
	global $cache;

	// Remove version code from cache
	$plugins = (array)$cache->read('ougc_plugins');

	if(isset($plugins['customlang']))
	{
		unset($plugins['customlang']);
	}

	if($plugins)
	{
		$cache->update('ougc_plugins', $plugins);
	}
	else
	{
		$cache->delete('ougc_plugins');
	}
}

// Load language file
function ougc_customlang()
{
	global $lang;

	isset($lang->ougc_customlang) or $lang->load('ougc_customlang');
}