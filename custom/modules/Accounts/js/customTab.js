let arr_module = ['activities', 'history', 'documents', 'opportunities', 'campaigns', 'leads', 'accounts', 'cases', 'account_aos_quotes', 'account_aos_invoices', 'account_aos_contracts', 'products_services_purchased', 'bugs', 'project', 'securitygroups'];
let tab_module = ['contacts']

var contactNo = 0;

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


function insertContacts(contacts){

    console.log(module_sugar_grp1);

    tableid = "contact";

    insertContactHeader(tableid);

    if (document.getElementById(tableid + '_head') !== null) {
        document.getElementById(tableid + '_head').style.display = "";
    }


    tablebody = document.createElement("tbody");
    tablebody.id = "contactBody" + contactNo;
    document.getElementById(tableid).appendChild(tablebody);

    var x = tablebody.insertRow(-1);
    x.id = 'contact_row' + contactNo;
  
    var a = x.insertCell(0);
    a.innerHTML = "<input type='text' name='name[" + contactNo + "]' id='name" + contactNo + "'  value='' title='' >";
  
    var b = x.insertCell(1);
    b.innerHTML = "<input autocomplete='off' type='email' name='email[" + contactNo + "]' id='email" + contactNo + "' value='' title=''>";

    var c = x.insertCell(2)
    c.innerHTML = "<input type='hidden' name='contact_deleted[" + contactNo + "]' id='contact_deleted" + contactNo + "' value='0'><button type='button' id='contact_delete" + contactNo + "' class='button contact_delete' value='' tabindex='116' onclick='markContactDeleted(" + contactNo + ")'><span class=\"suitepicon suitepicon-action-clear\"></span></button>";

    for(var c in contacts){
        console.log(c);
        if(document.getElementById(c + contactNo) !== null){
            document.getElementById(c + contactNo).value = contacts[c];
        }
    }

    if(contactNo == 0){
        insertContactFooter(tableid, contactNo);
    }

    contactNo++;

    return contactNo - 1;

}

 function insertContactHeader(tableid){
    tablehead = document.createElement("thead");
    tablehead.id = tableid +"_head";
    tablehead.style.display="none";
    document.getElementById(tableid).appendChild(tablehead);
  
    var x=tablehead.insertRow(-1);
    x.id='contact_head';
  
    var a=x.insertCell(0);
    a.style.color="rgb(68,68,68)";
    a.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_NAME');
  
    var b=x.insertCell(1);
    b.style.color="rgb(68,68,68)";
    b.innerHTML=SUGAR.language.get(module_sugar_grp1, 'LBL_EMAIL');
  
    var h=x.insertCell(2);
    h.style.color="rgb(68,68,68)";
    h.innerHTML='&nbsp;';
  }

  function insertContactFooter(tableid, contactNo){
    tablefooter = document.createElement("tfoot");
    tablefooter.id = tableid +"_tfoot";
    document.getElementById(tableid).appendChild(tablefooter);
    var footer_row=tablefooter.insertRow(-1);
    var footer_cell = footer_row.insertCell(0);
    footer_cell.scope="row";
    footer_cell.colSpan="20";
    footer_cell.innerHTML="<input type='button' tabindex='116' class='button add_contact' value='Add Contact' id='"+tableid+""+contactNo+"addContact' onclick='insertContacts(\""+tableid+""+contactNo+"\",\""+contactNo+"\")' />";
}

  function markContactDeleted(ln) {
  document.getElementById('contactBody' + ln).style.display = 'none';
  document.getElementById('contact_delete' + ln).value = '1';
  document.getElementById('contact_delete' + ln).onclick = '';

  /*if(checkValidate('EditView',key+'product_id' +ln)){
    removeFromValidate('EditView',key+'product_id' +ln);
  }*/
}