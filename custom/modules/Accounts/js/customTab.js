let arr_module = ['activities', 'history', 'documents', 'opportunities', 'campaigns', 'leads', 'accounts', 'cases', 'account_aos_quotes', 'account_aos_invoices', 'account_aos_contracts', 'products_services_purchased', 'bugs', 'project', 'securitygroups'];
let tab_module = ['contacts']

$(document).ready(function(){
    for(let i = 0; i < tab_module.length; i++){
        $('#whole_subpanel_'+tab_module[i]).hide();
    }
    
    $('#tab0').on('click', function(){
        showHide();
    });
});


function showTab (tab = "") {
    showHide(tab);
}

function showHide(tab){
    if(typeof tab !== 'undefined' && tab != ""){
        for(let i = 0; i < tab_module.length; i++){
            $('#whole_subpanel_'+tab_module[i]).show();
        }
    
        for(let i = 0; i < arr_module.length; i++){
            $('#whole_subpanel_'+arr_module[i]).hide();
        }
    } else {
        for(let i = 0; i < tab_module.length; i++){
            $('#whole_subpanel_'+tab_module[i]).hide();
        }
    
        for(let i = 0; i < arr_module.length; i++){
            $('#whole_subpanel_'+arr_module[i]).show();
        }
    }
}