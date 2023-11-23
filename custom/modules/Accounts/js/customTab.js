let rowNo = 0;
let totalCount = 1;

function insertRows(bean){
    tableid = "contact";

    insertRowHeader(tableid);

    if (document.getElementById(tableid + '_head') !== null) {
        document.getElementById(tableid + '_head').style.display = "";
    }

    document.getElementById('totalCount').value = totalCount;

    tablebody = document.createElement("tbody");
    tablebody.id = tableid+"Body" + rowNo;
    tablebody.classList.add('editListBody');
    document.getElementById(tableid).appendChild(tablebody);

    let x = tablebody.insertRow(-1);
    x.id = tableid+'_row' + rowNo + ' each_row';
  
    let i = 0;

    fields_def.forEach(function(element){
        if(element.label !== 'undefined'){
            let a = x.insertCell(i);
            a.id = 'type' + element.type;
            // a.innerHTML = getFieldsByType(element, rowNo, tableid);
            a.innerHTML = loadFieldHTML(element, rowNo, tableid);
            if(element.label !== 'undefined'){
                if(element.required !== 'undefined' && element.required == true){
                    addToValidate('EditView', tableid+'_'+element.name+rowNo, element.type, true, element.label + ' is required');
                }
            }
            if(i == 7){
                let b = x.insertCell(i+1);
                b.innerHTML = "<input type='hidden' name='"+tableid+"_id[]' id='id" + rowNo + "' value='0'><input type='hidden' name='"+tableid+"_deleted[]' id='"+tableid+"_deleted" + rowNo + "' value='0'><button type='button' id='"+tableid+"_delete" + rowNo + "' class='button "+tableid+"_delete' value='' tabindex='116' onclick='markRowDeleted(" + rowNo + ")'><span class=\"suitepicon suitepicon-action-clear\"></span></button>";
            }
        }
        i++;
    });

    for(let c in bean){
        if(c == 'id'){
           if(document.getElementById(c + rowNo) !== null){
            document.getElementById(c + rowNo).value = bean[c];
           }
        }
        if(document.getElementById(tableid+'_'+c + rowNo) !== null){
            document.getElementById(tableid+'_'+c + rowNo).value = bean[c];
        }
    }

    if(rowNo == 0){
        insertRowFooter(tableid, rowNo);
    }

    rowNo++;
    totalCount++;

    return rowNo - 1;

}

 function insertRowHeader(tableid){
    tablehead = document.createElement("thead");
    tablehead.id = tableid +"_head";
    tablehead.style.display="none";
    document.getElementById(tableid).appendChild(tablehead);
  
    var x=tablehead.insertRow(-1);
    x.id=tableid+'_head';
  
    let i = 0;

    fields_def.forEach(function(element){
        if(element.label !== 'undefined'){
            var a = x.insertCell(i);
            a.style.color = "rgb(68,68,68)";
            let error = '';
            if(element.required !== 'undefined' && element.required == true){
                error = ' ' + '<span class="required"> *</span>';
            }
            a.innerHTML = element.label + error;
        }
        i++;
    });
  }

function insertRowFooter(tableid, rowNo){
    tablefooter = document.createElement("tfoot");
    tablefooter.id = tableid +"_tfoot";
    document.getElementById(tableid).appendChild(tablefooter);
    var footer_row=tablefooter.insertRow(-1);
    var footer_cell = footer_row.insertCell(0);
    footer_cell.scope="row";
    footer_cell.colSpan="20";
    footer_cell.innerHTML="<input type='button' tabindex='116' class='button add_row' value='Add Record' id='"+tableid+""+rowNo+"addRow' onclick='insertRows(\""+tableid+""+rowNo+"\",\""+rowNo+"\")' />";
}

function markRowDeleted(ln) {
    let tableid = document.getElementById('tabmodule').value;
    document.getElementById(tableid+'Body' + ln).style.display = 'none';
    document.getElementById(tableid+'_deleted' + ln).value = '1';
    document.getElementById(tableid+'_deleted' + ln).onclick = '';
    fields_def.forEach(function(element){
        if(element.label !== 'undefined'){
            if(element.required !== 'undefined' && element.required == true){
                if(checkValidate('EditView',tableid+'_'+element.name +ln)){
                    removeFromValidate('EditView',tableid+'_'+element.name+ln);
                }
            }
        }
    });
}

function getFieldsByType(element, rowNo, type){
    switch (element.type) {
        case 'varchar':
            html = "<input type='text' name='"+type+'_'+element.name+"[]' id='" + type+'_'+element.name+rowNo + "'  value='' title='' >";
        return html;

        case 'enum':
            html = "<select name='"+type+'_'+element.name+"[]' id='" + type+'_'+element.name+rowNo + "'>'"+makeDropDown(element.options)+"'</selec>";
        return html;

        case 'name':
            html = "<input type='text' name='"+type+'_'+element.name+"[]' id='" + type+'_'+element.name+rowNo + "'  value='' title='' >";
        return html;

        case 'phone':
            html = "<input type='text' name='"+type+'_'+element.name+"[]' id='" + type+'_'+element.name+rowNo + "'  value='' title='' >";
        return html;
        
        case 'relate':
            let popup = 'open_popup("'+element.module+'", 600, 400, "", true, false, {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"'+ type+'_'+element.id_name+rowNo+'","'+element.rname+'":"'+type+'_'+element.name+rowNo+'"}}, "single", true)';
            let clear = 'SUGAR.clearRelateField(this.form, "'+ type+'_'+element.name+rowNo+'", "'+ type+'_'+element.id_name+rowNo+'")';
            html = "<div class='relatetype'><input type='text' name='"+type+'_'+element.name+"[]' id='" + type+'_'+element.name+rowNo + "'  value='' title='' ><input type='hidden' name='"+ type+'_'+element.id_name+"[]' id='"+ type+'_'+element.id_name+rowNo+"' value=''><button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button "+type+'_'+element.name+"_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='"+popup+"'><span class=\"suitepicon suitepicon-action-select\"></span></button><button title='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_TITLE') + "' accessKey='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_KEY') + "' type='button' tabindex='116' class='button "+type+'_'+element.name+"_button' value='" + SUGAR.language.get('app_strings', 'LBL_SELECT_BUTTON_LABEL') + "' name='btn1' onclick='"+clear+"'><span class=\"suitepicon suitepicon-action-clear\"></span></button></div>";
        return html;
        
    }
}

function makeDropDown(options){
    let salutation_dom = Object.keys(SUGAR.language.languages['app_list_strings'][options]);
    let html = "";
    for(let i = 0; i < salutation_dom.length; i++){
        html += '<option value='+salutation_dom[i]+'>'+salutation_dom[i]+'</option>'
    }
    return html;
}


function check_form(formname){
    customAddToValidate();
    if (typeof(siw) != 'undefined' && siw
    && typeof(siw.selectingSomething) != 'undefined' && siw.selectingSomething){
        return false;
    }
    return validate_form(formname, '');
}

function customAddToValidate(){
    let val = document.getElementById('totalCount').value;
    let tableid = document.getElementById('tabmodule').value;
    for(i = 0; i < val; i++){
        val = i;
    }
    fields_def.forEach(function(element){
        if(element.label !== 'undefined'){
            if(element.required !== 'undefined' && element.required == true){
                addToValidate('EditView', tableid+'_'+element.name+val, element.type, true, element.label + ' is required');
            }
        }
    });
}

function loadFieldHTML(element, rowNo, tableid) {
    $.ajaxSetup({ async: false });
    var result = $.getJSON("index.php", {
        module: "Accounts",
        action: "customSugarFields",
        field: element.name,
        current_module: 'Contacts',
        id: "",
        view: 'EditView',
        to_pdf: true,
        row_no: rowNo,
        table_id: tableid
    });
    $.ajaxSetup({ async: true });
    if (result.responseText) {
        try {
            return JSON.parse(result.responseText);
        } catch (e) {
            return false;
        }
    } else {
        return false;
    }
}