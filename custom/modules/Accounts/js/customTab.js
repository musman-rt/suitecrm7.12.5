let salutation_dom = Object.keys(SUGAR.language.languages['app_list_strings']['salutation_dom']);

let contactNo = 0;
let totalCount = 1;
function insertContacts(bean){
    
    tableid = "contact";

    insertContactHeader(tableid);

    if (document.getElementById(tableid + '_head') !== null) {
        document.getElementById(tableid + '_head').style.display = "";
    }

    document.getElementById('totalCount').value = totalCount;

    tablebody = document.createElement("tbody");
    tablebody.id = "contactBody" + contactNo;
    document.getElementById(tableid).appendChild(tablebody);

    let x = tablebody.insertRow(-1);
    x.id = 'contact_row' + contactNo;
  
    let i = 0;

    fields_def.forEach(function(element){
        if(element.label !== 'undefined'){
            let a = x.insertCell(i);
            a.innerHTML = getFieldsByType(element, contactNo, 'contact');
            if(i == 7){
                let b = x.insertCell(i+1);
                b.innerHTML = "<input type='hidden' name='contact_id[]' id='id" + contactNo + "' value='0'><input type='hidden' name='contact_deleted[]' id='contact_deleted" + contactNo + "' value='0'><button type='button' id='contact_delete" + contactNo + "' class='button contact_delete' value='' tabindex='116' onclick='markContactDeleted(" + contactNo + ")'><span class=\"suitepicon suitepicon-action-clear\"></span></button>";
            }
        }
        i++;
    });

    for(let c in bean){
        if(document.getElementById(c + contactNo) !== null){
            document.getElementById(c + contactNo).value = bean[c];
        }
    }

    if(contactNo == 0){
        insertContactFooter(tableid, contactNo);
    }

    contactNo++;
    totalCount++;

    return contactNo - 1;

}

 function insertContactHeader(tableid){
    tablehead = document.createElement("thead");
    tablehead.id = tableid +"_head";
    tablehead.style.display="none";
    document.getElementById(tableid).appendChild(tablehead);
  
    var x=tablehead.insertRow(-1);
    x.id='contact_head';
  
    let i = 0;

    fields_def.forEach(function(element){
        if(element.label !== 'undefined'){
            var a = x.insertCell(i);
            a.style.color = "rgb(68,68,68)";
            a.innerHTML = element.label;
        }
        i++;
    });
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
    document.getElementById('contact_deleted' + ln).value = '1';
    document.getElementById('contact_deleted' + ln).onclick = '';
}

function getFieldsByType(element, contactNo, type){
    switch (element.type) {
        case 'varchar':
            html = "<input type='text' name='"+type+'_'+element.name+"[]' id='" + element.name+contactNo + "'  value='' title='' >";
        return html;

        case 'enum':
            html = "<select name='"+type+'_'+element.name+"[]' id='" + element.name+contactNo + "'>'"+makeDP()+"'</selec>";
        return html;

        case 'name':
            html = "<input type='text' name='"+type+'_'+element.name+"[]' id='" + element.name+contactNo + "'  value='' title='' >";
        return html;

        case 'phone':
            html = "<input type='text' name='"+type+'_'+element.name+"[]' id='" + element.name+contactNo + "'  value='' title='' >";
        return html;
    }
}

function makeDP(){
    let html = "";
    for(let i = 0; i < salutation_dom.length; i++){
        html += '<option value='+salutation_dom[i]+'>'+salutation_dom[i]+'</option>'
    }
    return html;
}