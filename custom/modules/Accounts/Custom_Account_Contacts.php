<?php

/**
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

function custom_account_contacts($focus, $field, $value, $view)
{

    $html = '';
    if ($view == 'EditView') {

        $view = 'QuickCreate';

        $arr = array();


        require_once 'include/SubPanel/SubPanelDefinitions.php';
        $panelsdef = new SubPanelDefinitions($focus, '');
        $loadContactSubpanelDef = $panelsdef->load_subpanel('contacts', false, false, '', '');
        $contactSubpanelDefs = $loadContactSubpanelDef->panel_definition['list_fields'];
        $contactsLinkedBean = $focus->get_linked_beans('contacts', 'Contact');
        $contactFieldDef = $contactsLinkedBean[0]->field_name_map;
        foreach($contactFieldDef as $key => $value){
            if(!empty($contactSubpanelDefs[$key])){
                foreach($contactsLinkedBean as $mKey => $mValue){
                    $GLOBALS['log']->fatal('log ' . $key, $mValue->$key);
                    $GLOBALS['log']->fatal('log ' . $value, $value);
                }
            }
        }
        $contacts = json_encode($contactsLinkedBean);
        if (file_exists('custom/modules/Accounts/js/customTab.js')) {
            $html .= '<script src="custom/modules/Accounts/js/customTab.js"></script>';
        }

        $arr[0] = array('name' => 'Test', 'LBL_NAME' => 'Name',  'email' => 'test@test.com');
        $arr[1] = array('name' => 'Test1', 'email' => 'test1@test.com');

        $html .= "<table border='0' cellspacing='4' id='contact'></table>";

        foreach($arr as $val){
            $contacts = json_encode($val);
            $html .= "<script>
                insertContacts(".$contacts.");
            </script>";
        }
    }
    return $html;
}