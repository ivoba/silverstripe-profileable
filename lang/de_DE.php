<?php
// -------------------------------------------------------------------
// German translation for the Profileable Decorator
// -------------------------------------------------------------------

i18n::include_locale_file('Profileable', 'en_US');

global $lang;

if(array_key_exists('de_DE', $lang) && is_array($lang['de_DE'])) {
	$lang['de_DE'] = array_merge($lang['en_US'], $lang['de_DE']);
} else {
	$lang['de_DE'] = $lang['en_US'];
}

$lang['de_DE']['Profileable']['NAME'] = 'Name';
$lang['de_DE']['Profileable']['PROFILE'] = 'Profil';
$lang['de_DE']['Profileable']['ADDRESSADDITION'] = 'Adresszusatz';
$lang['de_DE']['Profileable']['CITY'] = 'Stadt';
$lang['de_DE']['Profileable']['PHONE'] = 'Tel.';
$lang['de_DE']['Profileable']['FAX'] = 'Fax';
$lang['de_DE']['Profileable']['EMAIL'] = 'E-Mail';
$lang['de_DE']['Profileable']['WWW'] = 'Internet';
$lang['de_DE']['Profileable']['PROFILEPICTURE'] = 'Profil Bild';