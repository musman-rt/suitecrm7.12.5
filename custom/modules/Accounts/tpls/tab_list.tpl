<div>
    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr class="editListBody">
            {foreach from=$CUSTOM_FIELDS_DEF item=field}
                <th>
                    {$field.label}
                </th>
            {/foreach}
        </tr>
        {$LIST_HTML}
    </table>
</div>
