<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Administration/controller.php';

class CustomAdministrationController extends AdministrationController

{
    public function action_tab_settings()
    {
        $this->view = 'tab_settings';

        if (isset($_REQUEST['process']) && $_REQUEST['process'] == 'true') {

            $admin = new Administration();

            $admin->retrieveSettings();

            if (!empty($_REQUEST["enable"])) {

                $arr = [];

                $arr[$_REQUEST['parent_module']] = array(0 => $_REQUEST['parent_module_value'], 1 => $_REQUEST['child_module'], 2 => $_REQUEST['child_module_value']);
                $arr['ENABLE'] = $_REQUEST['enable'];
                $arr['PARENTMODULES'] = $_REQUEST['parent_module'];
                $arr['CHILDMODULES'] = $_REQUEST['child_module'];

                $admin->saveSetting("tabOptions", "settings", json_encode($arr));
            }
            
            header('Location: index.php?module=Administration&action=index');
        }
    }
}
