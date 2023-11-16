<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $current_user;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

require_once('include/MVC/View/SugarView.php');

class ViewTab_settings extends SugarView
{
    public $ev;

    public function preDisplay()
    {

        $this->ev->tpl = 'custom/modules/Administration/tpls/tab_settings.tpl';
    }

    public function display()
    {
        global $mod_strings, $app_strings;
        $smarty = new Sugar_Smarty();
        $smarty->assign('MOD', $mod_strings);
        $admin = new Administration();
        $admin->retrieveSettings();

        $settings = html_entity_decode($admin->settings['tabOptions_settings']);
        $settings = json_decode($settings, true);

        $smarty->assign('ENABLEDROPDOWN', get_select_options_with_id($app_strings['LBL_TAB_SETTINGS_ENABLE'], $settings['ENABLE']));
        $smarty->assign('PARENTMODULES', get_select_options_with_id($GLOBALS['beanList'], $settings['PARENTMODULES']));
        $smarty->assign('CHILDMODULES', get_select_options_with_id($GLOBALS['beanList'], $settings['CHILDMODULES']));
        $checkModules = isset($settings[$settings['PARENTMODULES']]) ? $settings[$settings['PARENTMODULES']] : [];
        $smarty->assign('PARENTMODULEVALUE', $checkModules[0]);
        $smarty->assign('CHILDMODULEVALUE', $checkModules[2]);
        $smarty->display($this->ev->tpl);
    }
}
