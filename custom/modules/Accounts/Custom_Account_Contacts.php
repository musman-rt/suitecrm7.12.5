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
    $admin = new Administration();
    $admin->retrieveSettings();

    $settings = html_entity_decode($admin->settings['tabOptions_settings']);
    $settings = json_decode($settings, true);

    $tabModule = $settings[$focus->module_name];

    $html = '';

    if ($settings['ENABLE'] == 'no') {
        return;
    }

    require_once 'include/SubPanel/SubPanelDefinitions.php';
    $panelsdef = new SubPanelDefinitions($focus, '');
    $loadTabSubpanelDef = $panelsdef->load_subpanel(strtolower($tabModule[1]), false, false, '', '');
    $tabSubpanelDefs = $loadTabSubpanelDef->panel_definition['list_fields'];

    $fields_def = get_fields_defs($tabSubpanelDefs, $tabModule[2]);

    $focus->load_relationship(strtolower($tabModule[1]));

    $recordIDs = $focus->{strtolower($tabModule[1])}->get();

    $smarty = new Sugar_Smarty();

    $html .= '<script>let fields_def = ' . json_encode($fields_def) . '</script>';

    if ($view == 'EditView') {

        if (file_exists('custom/modules/Accounts/js/customTab.js')) {
            $smarty->assign('FILE_FLAG', 1);
        }

        $smarty->assign('TAB_MODULE', strtolower($tabModule[2]));

        $html .= $smarty->fetch('custom/modules/Accounts/tpls/data_list.tpl');

        if (count($recordIDs) != 0) {
            foreach ($recordIDs as $key => $recordID) {
                $bean = BeanFactory::newBean($tabModule[1]);
                $bean->retrieve($recordID, false);
                // $bean = json_encode($bean->toArray());
                $bean = $bean->toArray();

                $fieldHtml = "";
                $fieldHtml .= '<table><tr>';
                foreach ($fields_def as $value) {
                    $fieldHtmlTd = getTabViewHtml($tabModule[1], $value['name'], $bean['id'], $key, $tabModule[2]);
                    $fieldHtml .= '<td>' . $fieldHtmlTd . '</td>';
                }

                $fieldHtml .= '</tr></table>';

                $html .= $fieldHtml;

                // $html .= "<script>insertRows(" . $bean . ");</script>";
            }
        } else {
            // $html .= "<script>insertRows(" . $bean . ");</script>";
        }
    } else if ($view == 'DetailView') {
        $smarty->assign('CUSTOM_FIELDS_DEF', $fields_def);
        $listHtml = '';
        foreach ($recordIDs as $recordID) {
            $bean = BeanFactory::newBean($tabModule[1]);
            $bean->retrieve($recordID, false);
            $smarty->assign('TAB_BEAN', $bean->toArray());
            $listHtml .= $smarty->fetch('custom/modules/Accounts/tpls/data_list.tpl');
        }
        $smarty->assign('LIST_HTML', $listHtml);
        $html .= $smarty->fetch('custom/modules/Accounts/tpls/tab_list.tpl');
    }
    return $html;
}

function get_fields_defs($tabSubpanelDefs, $tabModule)
{

    $dummyBean = new $tabModule();

    $fields_list = array();
    $i = 0;

    foreach ($tabSubpanelDefs as $key => $value) {
        if (!empty($dummyBean->field_defs[$key]['name'])) {
            $fields_list[$i]['name'] = $dummyBean->field_defs[$key]['name'];
            $fields_list[$i]['type'] = $dummyBean->field_defs[$key]['type'];
            $fields_list[$i]['vname'] = $dummyBean->field_defs[$key]['vname'];
            $fields_list[$i]['label'] = translate($dummyBean->field_defs[$key]['vname'], 'Contacts');
            $fields_list[$i]['required'] = $dummyBean->field_defs[$key]['required'];
            if ($dummyBean->field_defs[$key]['type'] == 'relate') {
                $fields_list[$i]['module'] = $dummyBean->field_defs[$key]['module'];
                $fields_list[$i]['id_name'] = $dummyBean->field_defs[$key]['id_name'];
                $fields_list[$i]['rname'] = $dummyBean->field_defs[$key]['rname'];
            }
            if ($dummyBean->field_defs[$key]['type'] == 'enum') {
                $fields_list[$i]['options'] = $dummyBean->field_defs[$key]['options'];
            }
            $i++;
        }
    }

    return $fields_list;
}

function getTabViewHtml($module, $fieldname, $id, $key, $tabModule)
{
    include_once("custom/include/InlineEditing/InlineEditing.php");
    $html = json_decode(getEditFieldHTML($module, $fieldname, $fieldname, 'EditView', $id, '', '', $tabModule));
    $html = str_replace("id='".strtolower($tabModule).'_'.$fieldname."[]'", "id='".strtolower($tabModule)."_".$fieldname.$key."'", trim($html));
    return $html;
}
