<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/*********************************************************************************

 * Description:  base form for account
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/Accounts/Account.php';

class CustomAccount extends Account {

    public function __construct() {
        parent::__construct();
    }

    public function save($check_notify = false) {
        $tabModule = $this->return_tab_settings();
        $return_id =  parent::save($check_notify);
        $this->save_bean($_POST, $this, strtolower($tabModule[2].'_'), $return_id, $tabModule);
        return $return_id;
    }

    public function save_bean($records, $parent, $type, $return_id, $tabModule){
        $totalCount = $records['totalCount'];
        for ($i = 0; $i < $totalCount; ++$i) {
            $postData = null;
            if (isset($records[$type . 'deleted'][$i])) {
                $postData = $records[$type . 'deleted'][$i];
            } else {
                LoggerManager::getLogger()->warn($tabModule[2] . ' deleted field is not set in requested POST data at key: ' . $type . '['. $i .']');
            }

            if ($postData == 1) {
                $this->bean_deleted($records[$type . 'id'][$i], $tabModule[1]);
            } else {

                $dummyBean = new $tabModule[2]();

                if (!isset($records[$type . 'id'][$i])) {
                    $beanId = null;
                } else {
                    $beanId = $records[$type . 'id'][$i];
                }

                $dummyBean->retrieve($beanId);

                foreach ($dummyBean->field_defs as $field_def) {
                    $field_name = $field_def['name'];
                    if (isset($records[$type . $field_name][$i])) {
                        $dummyBean->$field_name = $records[$type . $field_name][$i];
                    }
                }

                $dummyBean->account_id = $return_id;
                $dummyBean->save();
            }
        }
    }

    public function bean_deleted($id, $tabModule)
    {
        if($id == 0){
            return;
        }
        $this->load_relationship(strtolower($tabModule));
        $this->{strtolower($tabModule)}->delete($this, $id);
    }

    public function return_tab_settings(){
        $admin = new Administration();
        $admin->retrieveSettings();
    
        $settings = html_entity_decode($admin->settings['tabOptions_settings']);
        $settings = json_decode($settings, true);
    
        $tabModule = $settings[$this->module_name];

        return $tabModule;
    }
}