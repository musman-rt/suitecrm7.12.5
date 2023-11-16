<script type="text/javascript">
{literal}
        function setVal(event, type) {
            const select = document.getElementById(type+'-module');
            var text = select.options[select.selectedIndex].text;
            document.getElementById(type+'-module-input').value = text;
        }

</script>
{/literal}

<form enctype='multipart/form-data' method="POST"
    action="index.php?module=Administration&action=tab_settings&process=true">

    <span class='error'>{$error.main}</span>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
        <tr>
            <td>
                <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
                    class="button primary" type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
                <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"
                    onclick="document.location.href='index.php?module=Administration&action=index'" class="button"
                    type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
        <tr>
            <th align="left" scope="row" colspan="6">
                <h4>{$MOD.LBL_TAB_SETTINGS}</h4>
            </th>
        </tr>
        <tr>
            <td nowrap width="10%" scope="row">{$MOD.LBL_TAB_SETTINGS_ENABLE_TITLE}: </td>
            <td width="25%">
                <select name="enable" required>
                    {$ENABLEDROPDOWN}
                </select>
            </td>

            <td nowrap width="10%" scope="row">{$MOD.LBL_TAB_SETTINGS_PARENT_MODULE_TITLE}: </td>
            <td width="25%">
                <select name="parent_module" required id="parent-module" onchange="setVal(event, 'parent')">
                    {$PARENTMODULES}
                </select>
                <input type="hidden" name="parent_module_value" value="{$PARENTMODULEVALUE}" id="parent-module-input">
            </td>

            <td nowrap width="10%" scope="row">{$MOD.LBL_TAB_SETTINGS_SUB_MODULE_TITLE}: </td>
            <td width="25%">
                <select name="child_module" required id="child-module" onchange="setVal(event, 'child')">
                    {$CHILDMODULES}
                </select>
                <input type="hidden" name="child_module_value" value="{$CHILDMODULEVALUE}" id="child-module-input">
            </td>

        </tr>
    </table>
    <div style="padding-top: 2px;">
        <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" type="submit" name="save"
            value="{$APP.LBL_SAVE_BUTTON_LABEL}"/>
        <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}"
            onclick="document.location.href='index.php?module=Administration&action=index'" class="button" type="button"
            name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
    </div>

</form>