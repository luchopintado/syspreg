/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    $("#cmb-nivel").live("change", getGradoByNivel);    
    $("#cmb-grado").live("change", getAreasByGrado);
    $("#cmb-area").live("change", getCursoByArea);
    
    
    $("#cmb-curso").live("change", getTemaByCurso);
    
    $("#cmb-tema").live("change", getSubtemaByTema);    
});

function getGradoByNivel(){
    var idnivel = $("#cmb-nivel").val() * 1;
    if(idnivel === 0){
        return;
    }
    var tpl = '<option value="0">Cargando ...</option>';
    var $combo = $("#cmb-grado");
    $combo.html(tpl).attr("disabled", "true");
    $.post(
        'admin_eval.php?action=getGradoByNivel',
        {            
            'idnivel': idnivel
        },
        function(data) {
            if(data.grados){
                tpl = '<option value="0">Seleccionar...</option>';
                $.each(data.grados, function(idx, el){
                    tpl += '<option value="'+el.cod_grado+'">'+el.grado+'</option>';
                });
                $combo.html(tpl).removeAttr("disabled");
            }else{
                alert("Ocurrio un error");
            }
        },
        'json'
    );
}

function getAreasByGrado() {
    var idgrado = $("#cmb-grado").val() * 1;
    if(idgrado === 0){
        return;
    }
    var tpl = '<option value="0">Cargando ...</option>';
    var $combo = $("#cmb-area");
    $combo.html(tpl).attr("disabled", "true");
    $.post(
        'admin_eval.php?action=getAreasByGrado',
        {            
            'idgrado': idgrado
        },
        function(data) {
            if(data.areas){
                tpl = '<option value="0">Seleccionar...</option>';
                $.each(data.areas, function(idx, el){
                    tpl += '<option value="'+el.cod_area+'">'+el.areas+'</option>';
                });
                $combo.html(tpl).removeAttr("disabled");
            }else{
                alert("Ocurrio un error");
            }
        },
        'json'
    );
}

function getCursoByGrado(){
    var idgrado = $("#cmb-grado").val() * 1;
    if(idgrado === 0){
        return;
    }
    var tpl = '<option value="0">Cargando ...</option>';
    var $combo = $("#cmb-area");
    $combo.html(tpl).attr("disabled", "true");
    $.post(
        'admin_eval.php?action=getCursoByGrado',
        {            
            'idgrado': idgrado
        },
        function(data) {
            if(data.cursos){
                tpl = '<option value="0">Seleccionar...</option>';
                $.each(data.cursos, function(idx, el){
                    tpl += '<option value="'+el.cod_area+'">'+el.areas+'</option>';
                });
                $combo.html(tpl).removeAttr("disabled");
            }else{
                alert("Ocurrio un error");
            }
        },
        'json'
    );
}

function getCursoByArea(){
    var idarea = $("#cmb-area").val() * 1;
    var idgrado = $("#cmb-grado").val() * 1;
    if(idarea === 0 || idgrado===0){
        return;
    }
    var tpl = '<option value="0">Cargando ...</option>';
    var $combo = $("#cmb-curso");
    $combo.html(tpl).attr("disabled", "true");
    $.post(
        'admin_eval.php?action=getCursoByArea',
        {            
            'idarea': idarea,
            'idgrado':idgrado
        },
        function(data) {
            if(data.cursos){
                tpl = '<option value="0">Seleccionar...</option>';
                $.each(data.cursos, function(idx, el){
                    tpl += '<option value="'+el.cod_curso+'">'+el.curso+'</option>';
                });
                $combo.html(tpl).removeAttr("disabled");
            }else{
                alert("Ocurrio un error");
            }
        },
        'json'
    );
}

function getTemaByCurso(){
    var idcurso = $("#cmb-curso").val() * 1;
    if(idcurso === 0){
        return;
    }

    var tpl = '<option value="0">Cargando ...</option>';
    var $combo = $("#cmb-tema");
    if($combo.size()<=0){
        return;
    }
    $combo.html(tpl).attr("disabled", "true");
    $.post(
        'admin_eval.php?action=getTemaByCurso',
        {            
            'idcurso': idcurso
        },
        function(data) {            
            if(data.temas){
                tpl = '<option value="0">Seleccionar...</option>';
                $.each(data.temas, function(idx, el){
                    tpl += '<option value="'+el.cod_tema+'">'+el.tema+'</option>';
                });
                $combo.html(tpl).removeAttr("disabled");
            }else{
                alert("Ocurrio un error");
            }
        },
        'json'
    );
}

function getSubtemaByTema(){
    var idtema = $("#cmb-tema").val() * 1;
    if(idtema === 0){
        return;
    }
    var tpl = '<option value="0">Cargando ...</option>';
    var $combo = $("#cmb-subtema");
    $combo.html(tpl).attr("disabled", "true");
    $.post(
        'admin_eval.php?action=getSubtemaByTema',
        {            
            'idtema': idtema
        },
        function(data) {
            if(data.subtemas){
                tpl = '<option value="0">Seleccionar...</option>';
                $.each(data.subtemas, function(idx, el){
                    tpl += '<option value="'+el.cod_subtema+'">'+el.subtema+'</option>';
                });
                $combo.html(tpl).removeAttr("disabled");
            }else{
                alert("Ocurrio un error");
            }
        },
        'json'
    );
}