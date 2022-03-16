<?php
/**
 * @version		$Id: test.php 2022-3-16 12:59Z mic $
 * @package		Boilerplate for event in OpenCart 2.x
 * @author		mic - https://osworx.net
 * @copyright	2022 OSWorX
 * @license		MIT
 *
 * note: define only those variables which are not already defined elsewhere
 * (e.g. inside the master language file)
 * or those which shall be overriden
 */

// browser title and part of breadcrumb
$_['heading_title']		= 'Boilerplate event';

// common values
$_['text_extension']	= 'Extension'; // could be also Module, Shipping, Payment
$_['text_success']		= 'Data successfully saved';
// form values
$_['text_status']		= 'Status';
$_['text_bold']			= '<b>Bold</b>';	// values can be styled too (simple)
$_['text_italic']		= '<i>Italic</i>';

// tabs
$_['tab_setting']		= 'Setting 1';
$_['tab_second']		= '2nd Tab';

// form entry values
$_['entry_status']		= 'Status';
$_['entry_second']		= 'Second';

// inline (tooltip) help for form values
$_['help_status']		= 'En-/Disables this extension';
$_['help_second']		= 'A <i style=&quot;color:coral&quot;>second</i> value'; // also help can be styled
// outline (wells) help
$_['help_setting']		= 'An explaination what for, purpose, help for the fields below, etc. the user may find helpfull ..';
// tab help (optional)
$_['help_tab_setting']	= 'A help for this tab';
$_['help_tab_second']	= 'A help for this 2nd tab';

// buttons
$_['btn_apply']			= 'Apply';

// error messages
$_['error_modify']		= 'No permission to edit';
$_['error_access']      = 'No permission to open this extension';

// vars/values used in events - here all with placeholders
$_['text_subject']		= 'Hello %s %s,';
$_['text_body']			= '<p>here is your new login data for %s.</p><p>Below you will find your access data for %s<br>As username please use <b>%s</b>, your password is <b>%s</b>.</p>Regards<br>%s<br>%s';
