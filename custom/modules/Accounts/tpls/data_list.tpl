{if $FILE_FLAG == 1}

    {literal}
        <script src="custom/modules/Accounts/js/customTab.js"></script>
    {/literal}

    <table border='0' cellspacing='4' id='{$TAB_MODULE}'></table>
    <input type='hidden' name='totalCount' id='totalCount' value=''>
    <input type='hidden' name='tabmodule' id='tabmodule' value='{$TAB_MODULE}'>

{else}

    <tr class="listContacts">
    {foreach from=$CUSTOM_FIELDS_DEF item=field}
        {assign var='name' value=$field.name}
        <td class="tabDetailViewDL" style='text-align: left;padding:2px;'>
            {$TAB_BEAN.$name}
        </td>
    {/foreach}
    </tr>

{/if}