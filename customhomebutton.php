<?php

/*******************************************************************************
 * Custom Home Button
 *
 * Copyright (c) 2023 @rjen
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 ******************************************************************************/

if (!defined('SMF'))
    die('No direct access...');

/**
 * Add the settings to admin
 *
 * Called by:
 * 		integrate_general_mod_settings
 */
function customhomebutton_settings(&$config_vars)
{
	global $txt;
	loadLanguage('customhomebutton');

	$config_vars[] = '';
	$config_vars[] = $txt['customhomebutton'];
	$config_vars[] = array('text', 'customhomebutton_link', 'size' => 70, 'subtext' => $txt['customhomebutton_linkdesc']);
}

/**
 * Add the menu button
 * Called by:
 * 		integrate_menu_buttons
 */
 function customhomebutton(&$buttons)
{
	global $modSettings, $txt, $context, $scripturl;
	loadLanguage('customhomebutton');

	if (!empty($modSettings['customhomebutton_link'])) {

		$counter = 0;
		foreach ($buttons as $name => $array)
		{
			$counter++;
			if ($name == 'home')
				break;
		}
		// Overwrite the Home button
		$buttons = array_merge(
		array_slice($buttons, 0, $counter, TRUE),
			array(
			'home' => array(
				'title' => $txt['home'],
				'href' => $modSettings['customhomebutton_link'],
				'show' => true,
				'target' => '_blank',
				'sub_buttons' => array(
				),
				'is_last' => $context['right_to_left'],
			)
		),
		array_slice($buttons, $counter, NULL, TRUE)
		);
		// Add the forum button
		$buttons = array_merge(
		array_slice($buttons, 0, array_search('home', array_keys($buttons), true) + 1),
			array (
			'forum' => array (
				'title' => $txt['forum_button'],
				'href' => $scripturl,
				'show' => true,
				'icon' => 'personal_message',
			),
		),
		array_slice($buttons, $counter, NULL, TRUE)
		);
	}
}

/**
 * Add the menu button
 * Called by:
 * 		integrate_current_action
 */
 function customhomeaction(&$current_action)
{
	global $modSettings, $context;

	// Set the forum button activated if needed.
	if (!empty($modSettings['customhomebutton_link'])) {

		if(empty($context['current_action']))
			$current_action = 'forum';
	}
}


/**
 * Mention who made this thing
 *
 * Called by:
 * 		integrate_credits
 */
function customhomebutton_credits()
{
	global $context;
	$context['copyrights']['mods'][] = 'Custom Home Button link by @rjen &copy; 2023';
}