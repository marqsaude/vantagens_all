function openServicos(type){
    $(function(){
        if(type==1) {
            $("#dialog_consultas").dialog("open");
        }
        if(type==2) {
            $("#dialog_exames").dialog("open");
        }
        if(type==3) {
            $("#dialog_laboratoriais").dialog("open");
        }
        if(type==4) {
            $("#dialog_Single").dialog("open");
        }
        if(type==5) {
            $("#dialog_Plus").dialog("open");
        }
        if(type==6) {
            $("#dialog_Master").dialog("open");
        }
    });
}

function closeServicos(type){
    if(type==4) {
        $("#dialog_Single").dialog("close");
    }
    if(type==5) {
        $("#dialog_Plus").dialog("close");
    }
    if(type==6) {
        $("#dialog_Master").dialog("close");
    }
}