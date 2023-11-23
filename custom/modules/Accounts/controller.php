<?php

class AccountsController extends SugarController
{

    function action_customSugarFields()
    {
        include_once("custom/include/InlineEditing/InlineEditing.php");
        $html = json_decode(getEditFieldHTML($_REQUEST['current_module'], $_REQUEST['field'], $_REQUEST['field'], $_REQUEST['view'], '', '', '', $_REQUEST['table_id']));
        $html = str_replace("id='".strtolower($_REQUEST['table_id']).'_'.$_REQUEST['field']."[]'", "id='".strtolower($_REQUEST['table_id'])."_".$_REQUEST['field'].$_REQUEST['row_no']."'", $html);
        $html = str_replace("name='".strtolower($_REQUEST['table_id']).'_'.$_REQUEST['field']."[]'", "name='".strtolower($_REQUEST['table_id'])."_".$_REQUEST['field']."[".$_REQUEST['row_no']."]'", $html);
        echo json_encode($html);
    }
}
