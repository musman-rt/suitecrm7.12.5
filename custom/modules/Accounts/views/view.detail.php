<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('modules/Accounts/views/view.detail.php');

class CustomAccountsViewDetail extends AccountsViewDetail
{

    public function display(){

        /*global $mod_strings;


        $mod_strings['LBL_CONTACTS_TAB'] = 'CONTACTS';

        $subpanel = 'contacts';
        $record = $this->bean->id;
        $module = 'Accounts';

        $collection = array();

        include 'include/SubPanel/SubPanel.php';
        require_once 'include/SubPanel/SubPanelDefinitions.php';

        $spd = new SubPanelDefinitions($this->bean);

        $aSubPanelObject = $spd->load_subpanel($subpanel, false, false, '', $collection);
        $subpanel_object = new SubPanel($module, $record, $subpanel, $aSubPanelObject, $layout_def_key, $collection);
        $subpanel_object->setTemplateFile('include/SubPanel/tpls/SubPanelDynamic.tpl');*/
        // $subpanel_object->display(false)
        

        /*$smarty = new Sugar_Smarty();
        $tpl->assign('ROWS', $mod_strings);
        $notesHtml = $smarty->fetch('include/SubPanel/tpls/SubPanelDynamic.tpl');*/



        $this->dv->defs['templateMeta']['tabDefs']['LBL_CONTACTS'] = array(
            'newTab' => true,
            "panelDefault" => "expanded"
        );

        $this->dv->defs['panels']['LBL_CONTACTS'] = array(
            array (
                0 => 
                array (
                  'name' => 'name',
                  'comment' => 'Name of the Company',
                  'label' => 'LBL_NAME',
                ),
                1 => 
                array (
                  'name' => 'phone_office',
                  'comment' => 'The office phone number',
                  'label' => 'LBL_PHONE_OFFICE',
                ),
                2 => 
                array(
                    'name' => 'website',
                    'customCode' => '<div>abc</div>',
                ),
              ),
        );

        $GLOBALS['log']->fatal('bean', print_r($this, 1));
        parent::display();
    }

}