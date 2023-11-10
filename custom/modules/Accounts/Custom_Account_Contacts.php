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
    global $sugar_config;
    $tabModule = $sugar_config['tabOptions']['modules'][$focus->module_name];

    $html = '';

    require_once 'include/SubPanel/SubPanelDefinitions.php';
    $panelsdef = new SubPanelDefinitions($focus, '');
    $loadTabSubpanelDef = $panelsdef->load_subpanel(strtolower($tabModule.'s'), false, false, '', '');
    $tabSubpanelDefs = $loadTabSubpanelDef->panel_definition['list_fields'];

    $fields_def = get_fields_defs($tabSubpanelDefs, $tabModule);

    $focus->load_relationship(strtolower($tabModule.'s'));

    $recordIDs = $focus->{strtolower($tabModule.'s')}->get();

    $html .= '<script>let fields_def = '.json_encode($fields_def).'</script>';

    if ($view == 'EditView') {

        if (file_exists('custom/modules/Accounts/js/customTab.js')) {
            $html .= '<script src="custom/modules/Accounts/js/customTab.js"></script>';
        }

        $html .= "<table border='0' cellspacing='4' id='contact'></table>";
        $html .= "<input type='hidden' name='totalCount' id='totalCount' value=''>";

        if(count($recordIDs) != 0) {
            foreach($recordIDs as $recordID){
                $bean = BeanFactory::newBean($tabModule.'s');
                $bean->retrieve($recordID, false);
                $bean = json_encode($bean->toArray());
                $html .= "<script>insert".$tabModule.'s'."(".$bean.");</script>";
            }
        } else {
            $html .= "<script>insert".$tabModule.'s'."(".$bean.");</script>";
        }
    } else if($view == 'DetailView'){
        $no = 1;
        $html .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        $html .= "<tr><td colspan='9' nowrap='nowrap'><br></td></tr>";
        $html .= '<tr>';
        $html .= '<td class="tabDetailViewDL" colspan="9" style="text-align: left;padding:2px;">No.</td>';
        foreach($fields_def as $key => $field){
            $html .= '<td class="tabDetailViewDL" colspan="9" style="text-align: left;padding:2px;">'.$field['label'].'</td>';
        }
        $html .= '</tr>';
        foreach($recordIDs as $recordID){
            $bean = BeanFactory::newBean($tabModule.'s');
            $bean->retrieve($recordID, false);
            $html .= '<tr>';
            $html .= '<td class="tabDetailViewDL" colspan="9" style="text-align: left;padding:2px;">'.$no.'</td>';
            foreach($tabSubpanelDefs as $key => $value){
                $html .= '<td class="tabDetailViewDL" colspan="9" style="text-align: left;padding:2px;">'.$bean->$key.'</td>';
            }
            $html .= '</tr>';
            $no++;
        }
        $html .= "</table>";
    }
    return $html;
}

function get_fields_defs($tabSubpanelDefs, $tabModule){

    $dummyBean = new $tabModule();

    $fields_list = array();
    $i = 0;
    
    foreach($tabSubpanelDefs as $key => $value){
        if(!empty($dummyBean->field_defs[$key]['name'])){
            $fields_list[$i]['name'] = $dummyBean->field_defs[$key]['name'];
            $fields_list[$i]['type'] = $dummyBean->field_defs[$key]['type'];
            $fields_list[$i]['vname'] = $dummyBean->field_defs[$key]['vname'];
            $fields_list[$i]['label'] = translate($dummyBean->field_defs[$key]['vname'], 'Contacts');
            $i++;
        }
    }

    return $fields_list;
}