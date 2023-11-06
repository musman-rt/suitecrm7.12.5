<?php

$dictionary['Account']['fields']['custom_account_contacts'] = array (
    'required' => false,
    'name' => 'custom_account_contacts',
    'vname' => 'LBL_CUSTOM_ACCOUNT_CONTACTS',
    'type' => 'function',
    'source' => 'non-db',
    'massupdate' => 0,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'inline_edit' => false,
    'function' => array(
            'name' => 'custom_account_contacts',
            'returns' => 'html',
            'include' => 'custom/modules/Accounts/Custom_Account_Contacts.php'
    ),
);