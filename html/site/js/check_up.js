/**
 * Created by tony on 09/11/15.
 */

var _id=0;

function mountHtmlMulher(){
    var html='';
    if(_id!=1) {
        marqSetUp(1);
        html = '<div style="margin-top: 77px; font-size: 37px; color: #ce7c8a; margin-left: 38%;"><img src="site/images/check_up/mais_mulher.png" width="55" style="float: left; display: none;" /><div style="float: left; margin-left: 10px; margin-top: 10px;">Saúde Mulher</div></div><br/><br/>';
        html += '<div class="custom">';
        html += '<p>&nbsp;</p>';
        html += '<p style="font-size: 20px;"><b>Consulta Ginecologista</b></p>';
        html += '<p style="font-size: 20px;"><b>Exames Preventivos (papanicolau, vulvoscospia, coposcopia e exame A fresco)</b></p>';
        html += '<p style="font-size: 20px;"><b>Exame de Densitometria Óssea</b></p>';
        html += '<p><center style="font-size: 20px;">R$ 500,00</center></p>';
        html += '<p style="margin-top: 40px;"><center style="font-size: 18px;">Invista na saúde preventiva.</center></p>';
        html += '</div>';
    }else{
        hiddenAll();
        _id=0;
    }
    jQuery(function() {
        jQuery("#check-up").html(html);
    });
}

function mountHtmlFitness(){
    var html='';
    if(_id!=4) {
        marqSetUp(4);
        html = '<div style="margin-top: 77px; font-size: 37px; color: #5fc4ba; margin-left: 38%;"><img src="site/images/check_up/mais_fitness.png" width="55" style="float: left; display: none;"/><div style="float: left; margin-left: 10px; margin-top: 10px;">Saúde Fitness</div></div><br/><br/>';
        html += '<div class="custom">';
        html += '<p>&nbsp;</p>';
        html += '<p style="font-size: 20px;"><b>Consulta Endocrinologista</b></p>';
        html += '<p style="font-size: 20px;"><b>Avaliação Metabólica</b></p>';
        html += '<p style="font-size: 20px;"><b>Mapa + Holter 24 Horas + ECG (Eletrocardiograma)</b></p>';
        html += '<p><center style="font-size: 20px;">R$ 580,00</center></p>';
        html += '<p style="margin-top: 40px;"><center style="font-size: 18px;">Invista na saúde preventiva.</center></p>';
        html += '</div>';
    }else{
        hiddenAll();
        _id=0;
    }
    jQuery(function() {
        jQuery("#check-up").html(html);
    });
}

function mountHtmlIdade(){
    var html='';
    if(_id!=3) {
        marqSetUp(3);
        html = '<div style="margin-top: 77px; font-size: 37px; color: #9dc49d; margin-left: 34%;"><img src="site/images/check_up/mais_idade.png" width="55" style="float: left; display: none;"/><div style="float: left; margin-left: 10px; margin-top: 10px;">Saúde Melhor Idade</div></div><br/><br/>';
        html += '<div class="custom">';
        html += '<p>&nbsp;</p>';
        html += '<p style="font-size: 20px;"><b>Consulta Neurologista</b></p>';
        html += '<p style="font-size: 20px;"><b>Mapa + Holter 24 Horas + ECG (Eletrocardiograma)</b></p>';
        html += '<p><center style="font-size: 20px;">R$ 500,00</center></p>';
        html += '<p style="margin-top: 40px;"><center style="font-size: 18px;">Invista na saúde preventiva.</center></p>';
        html += '</div>';
    }else{
        hiddenAll();
        _id=0;
    }
    jQuery(function() {
        jQuery("#check-up").html(html);
    });
}

function mountHtmlHomem(){
    var html='';
    if(_id!=2) {
        marqSetUp(2);
        html = '<div style="margin-top: 77px; font-size: 37px; color: #62a1c4; margin-left: 37%;"><img src="site/images/check_up/mais_homem.png" width="55" style="float: left; display: none;"/><div style="float: left; margin-left: 10px; margin-top: 10px;">Saúde Homem</div></div><br/><br/>';
        html += '<div class="custom">';
        html += '<p>&nbsp;</p>';
        html += '<p style="font-size: 20px;"><b>Consulta Cardiologista</b></p>';
        //html += '<p style="font-size: 20px;"><b>Consulta Cardiológica</b>&nbsp;&nbsp;&nbsp;R$ 200,00</p>';
        html += '<p style="font-size: 20px;"><b>Mapa + Holter 24 Horas + ECG (Eletrocardiograma)</b></p>';
        html += '<p><center style="font-size: 20px;">R$ 500,00</center></p>';
        html += '<p style="margin-top: 40px;"><center style="font-size: 18px;">Invista na saúde preventiva.</center></p>';
        html += '</div>';
    }else{
        hiddenAll();
        _id=0;
    }
    jQuery(function() {
        jQuery("#check-up").html(html);
    });
}

function hiddenAll(){
    jQuery(function() {
        jQuery(".up_checkup").hide();
    });
}

function marqSetUp(id){
    hiddenAll();
    _id=id;
    switch (id){
        case 1 :
            jQuery(function() {
                jQuery("#up_mulher").show();
            });
            break;
        case 2 :
            jQuery(function() {
                jQuery("#up_homem").show();
            });
            break;
        case 3 :
            jQuery(function() {
                jQuery("#up_idade").show();
            });
            break;
        case 4 :
            jQuery(function() {
                jQuery("#up_fitness").show();
            });
            break;
    }
}

function mountHtmlPreco(){
    var html;
    html = '<br/><a href="javascript:void(0);" onclick="mountHtmlOriginal();" id="mais_back"><img src="images/check_up/back_preco.png" width="40" height="40"/></a><center style="margin-top: -35px;"><img src="images/check_up/check.png" width="370" height="49" /></center>';
    html += '<div class="custom">';
    html += '<p>&nbsp;</p>';
    html += '<p style="font-size: 26px; color: #fa0002">TABELA DE VALORES</p>';
    //html += '<p style="font-size: 17px;"><b>Avaliação Auditiva:</b> Audiometria e impedanciometria</p>';
    html += '<p style="font-size: 20px;"><b>Check up Saúde Mulher - </b> R$ 1.705,00</p>';
    html += '<p style="font-size: 20px;"><b>Check up Saúde Fitness - </b> R$ 1.695,00</p>';
    html += '<p style="font-size: 20px;"><b>Check up Saúde Melhor Idade - </b> R$ 1.864,00 (Feminino) e R$ 1.735,00 (Masculino)</p>';
    html += '<p>&nbsp;</p>';
    html += '<p>&nbsp;</p>';
    html += '<center><p style="font-size: 20px;"><b>Atendemos Convênios</b></p></center>';
    html += '<center><p style="font-size: 20px;"><b>Aceitamos cartões de créditos - </b> em até 05 vezes sem juros.</p></center>';
    html += '<center><p style="margin-top: 77px;"><center>Invista em sua saúde, o seu maior patrimônio.</center></p></center>';
    html += '</div>';
    jQuery(function() {
        jQuery("#check-up").html(html);
    });
}

/*function mountHtmlOriginal(){
    var html;
    html = '<br/><center style="margin-top: 5px;"><img src="images/check_up/check.png" width="370" height="49" /></center>';
    html += '<div class="custom">';
    html += '<p>&nbsp;</p>';
    html += '<p style="font-size: 16px;">Criado para avaliar a saúde dos nossos pacientes de maneira completa e personalizada, de acordo com a faixa etária, histórico pessoal, hábitos de vida e antecedentes familiares.</p>';
    html += '<p style="font-size: 32px; color: #e618ca;" id="mais_mulher"><a href="javascript:void(0);" onclick="mountHtmlMulher();"><img src="images/check_up/mais_mulher.png" width="55" height="51" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saúde Mulher</a></p>';
    html += '<p>&nbsp;</p>';
    html += '<p style="font-size: 32px; color: #52ac4b;" id="mais_fitness"><a href="javascript:void(0);" onclick="mountHtmlFitness();"><img src="images/check_up/mais_fitness.png" width="55" height="51" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saúde Fitness</a></p>';
    html += '<p>&nbsp;</p>';
    html += '<p style="font-size: 32px; color: #005de1;" id="mais_idade"><a href="javascript:void(0);" onclick="mountHtmlIdade();"><img src="images/check_up/mais_idade.png" width="55" height="51" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saúde Melhor Idade</a></p>';
    html += '<center><p style="margin-top: 27px;" id="mais_preco"><a href="javascript:void(0);" onclick="mountHtmlPreco();">Tabela de valores check up.</a></p></center>';
    html += '</div>';
    jQuery(function() {
        jQuery("#check-up").html(html);
    });
}*/