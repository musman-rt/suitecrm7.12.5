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
        $tabModule = $GLOBALS['sugar_config']['tabOptions']['modules'][$this->module_name];

        $this->save_contact($_POST, $this, strtolower($tabModule.'_'));
        return parent::save($check_notify);

    }

    public function save_contact($records, $parent, $type){
        $tabModule = $GLOBALS['sugar_config']['tabOptions']['modules'][$this->module_name];

        $totalCount = $records['totalCount'];
        for ($i = 0; $i < $totalCount; ++$i) {
            $postData = null;
            if (isset($records[$type . 'deleted'][$i])) {
                $postData = $records[$type . 'deleted'][$i];
            } else {
                LoggerManager::getLogger()->warn($tabModule . ' deleted field is not set in requested POST data at key: ' . $type . '['. $i .']');
            }

            if ($postData == 1) {
                $this->bean_deleted($records[$type . 'id'][$i], $tabModule);
            } else {

                $dummyBean = new $tabModule();

                if (!isset($records[$type . 'id'][$i])) {
                    $contactId = null;
                } else {
                    $contactId = $records[$type . 'id'][$i];
                }

                $contact = BeanFactory::getBean($tabModule.'s', $contactId);
                if (!$contact) {
                    $contact = BeanFactory::newBean($tabModule.'s');
                }

                foreach ($dummyBean->field_defs as $field_def) {
                    $field_name = $field_def['name'];
                    if (isset($records[$type . $field_name][$i])) {
                        $contact->$field_name = $records[$type . $field_name][$i];
                    }
                }

                $contact->save();
            }
        }
    }

    public function bean_deleted($id, $tabModule)
    {
        $bean = BeanFactory::newBean($tabModule.'s');
        $bean->retrieve($id, false);
        $GLOBALS['log']->fatal(print_r($bean, 1));
        $bean->mark_deleted($bean->id);
    }
}