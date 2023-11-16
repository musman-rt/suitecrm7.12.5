<?php

$admin_option_defs = array();
$admin_option_defs['Administration']['tab_settings'] = array(
    'Administration',
    'LBL_TAB_SETTINGS',
    'LBL_TAB_SETTINGS_DESCRIPTION',
    './index.php?module=Administration&action=tab_settings',
);
$admin_group_header[] = array('LBL_TAB_SETTINGS_SECTION_HEADER', '', false, $admin_option_defs, 'LBL_TAB_SETTINGS_SECTION_DESCRIPTION');
