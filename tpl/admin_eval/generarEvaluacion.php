<?php include TEMPLATE_PATH . '/inc/top.php';?>
<body>
    
    <?php include TEMPLATE_PATH . '/inc/nav.php';?>
    
    <div class="container">
     
        
        <div id="main" role="main">
           
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span3">
                        <?php include TEMPLATE_PATH . '/admin_eval/inc.submenu.evaluacion.php';?>
                    </div>
                    <div class="span9">
                        
                        <div class="page-header">
                            <h1>Generar evaluaci&oacute;n</h1>                
                        </div>

                        <?php if(isset($results["errorMessage"])): ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <b>Error</b>: <?php echo $results["errorMessage"]; ?>
                        </div>
                        <?php endif; ?>

                        <?php if(isset($results["statusMessage"])): ?>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <b>Estado</b>: <?php echo $results["statusMessage"]; ?>
                        </div>
                        <?php endif; ?>

                        <form action="admin_eval.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal eval-form" id="form-generarevaluacion">
                            <legend>Generales</legend>
                            <div class="control-group">
                                <label for="cmb-nivel" class="control-label">Nivel de estudios:</label>
                                <div class="controls">
                                    <input type="hidden" name="cod_evaluacion" value="<?php echo $results["evaluacion"]->cod_evaluacion; ?>"/>
                                    <select class="input-xxlarge" id="cmb-nivel" name="cod_nivel" required="required">
                                        <option value="0">Seleccionar...</option>
                                        <?php $niveles = Nivel::getList();?>
                                        <?php foreach ($niveles["niveles"] as $nivel): ?>
                                            <option value="<?php echo $nivel->cod_nivel?>"><?php echo $nivel->nivel;?></option>                                            
                                        <?php endforeach; ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-grado" class="control-label">Grado:</label>
                                <div class="controls">                                    
                                    <select class="input-xxlarge" id="cmb-grado" name="cod_grado" required="required">
                                        <option value="0">Seleccionar...</option>                                        
                                    </select>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-area" class="control-label">Area:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-area" name="cod_area" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-curso" class="control-label">Curso:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-curso" name="cod_curso" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label for="cmb-capacidad" class="control-label">Capacidad:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-capacidad" name="id_capacidad" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label for="cmb-tema" class="control-label">Tema:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-tema" name="cod_tema" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-subtema" class="control-label">Subtema (Opcional):</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-subtema" name="cod_subtema">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            
                            <legend>Numero de Preguntas</legend>
                            <div class="control-group">          
                                <label class="control-label">Nivel de dificultad:</label>
                                <div class="controls">
                                    <?php $nivelesdificultad = NivelDificultad::getList();?>
                                    <?php foreach ($nivelesdificultad["nivelesdificultad"] as $nd): ?>
                                    <label for="txt-nropreguntas-basico" class="control-label inline"><?php echo $nd->niveldificultad;?>
                                        <input type="number" min="0" step="1" class="input-mini" name="nropreguntas-<?php echo $nd->cod_niveldificultad; ?>" id="txt-nropreguntas-<?php echo $nd->cod_niveldificultad; ?>"  value="" required="required"/>
                                    </label>
                                    <?php endforeach; ?>                                    
                                </div>                                
                            </div>
                            <div class="control-group">
                                <label for="txt-nropreguntas" class="control-label">Total de preguntas:</label>
                                <div class="controls">
                                    <label for="txt-nropreguntas" class="control-label inline">
                                        <input type="text" class="input-mini" name="nro_preguntas" id="txt-nropreguntas"  value="" readonly="readonly"/>                                        
                                    </label>
                                </div>
                            </div>
                            
                            <legend>Tipo de Evaluaci&oacute;n</legend>
                            <div class="control-group">
                                <div class="controls">
                                    <?php $tipoevaluaciones = TipoEvaluacion::getList();?>
                                    <?php foreach ($tipoevaluaciones["tipoevaluaciones"] as $te): ?>
                                    <label class="radio inline">
                                        <input type="radio" data-label="<?php echo $te->tipoevaluacion; ?>" name="rb_tipoevaluacion" value="<?php echo $te->cod_tipoevaluacion; ?>"> <?php echo $te->tipoevaluacion; ?>
                                    </label>                                    
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <legend>Trimestre</legend>
                            <div class="control-group">
                                <div class="controls">
                                    <?php $trimestres = Trimestre::getList();?>
                                    <?php foreach ($trimestres["trimestres"] as $t): ?>
                                    <label class="radio inline">
                                        <input type="radio" data-label="<?php echo $t->trimestre; ?>" name="rb-trimestre" value="<?php echo $t->cod_trimestre; ?>">Trimestre <?php echo $t->trimestre; ?></label>                                    
                                    <?php endforeach; ?>
                                    <label class="radio inline">
                                        <input type="radio" data-label="Final" name="rb-trimestre" value="4"> Final
                                    </label>                                    
                                </div>
                            </div>
                            
                            <hr/>
                            
                            <div class="control-group">
                                <div class="controls pull-left">
                                    <button type="submit" name="saveChanges" class="btn">Generar evaluaci&oacute;n autom&aacute;ticamente</button>                                                            
                                    <a href="admin_eval.php?action=getQuestions" id="btn-editar-alternativa" role="button" class="btn" data-toggle="modal">Generar evaluaci&oacute;n manualmente</a>
                                </div>
                            </div>

                        </form>
                        
                        <form action="admin_eval.php?action=exportMSWord" method="post" class="form-horizontal eval-form" id="form-vistaprevia">
                            
                            <legend>Vista previa</legend>                                
                            <div class="control-group">
                                <input type="text" name="e_nombre" id="txt-encabezado" />
                            </div>
                            <div class="span12">
                                <div id="render-eval">
                                </div>
                            </div>
                            <hr/>
                            <div class="control-group">
                                <div class="controls pull-right">
                                    <!-- Guarda cambios en la base de datos y te manda a descargar en WORD-->
                                    <button type="submit" name="saveChanges" value="Guardar Evaluacion" class="btn btn-primary "><i class="icon-hdd icon-white"></i> Guardar evaluaci&oacute;n</button>
                                </div>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div id="modalPreguntas" class="modal hide fade modal-preguntas" tabindex="-1" role="dialog" aria-labelledby="modalPreguntas" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Seleccionar preguntas</h3>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <button class="btn btn-primary" id="btn-generar-evaluacion">Generar Evaluaci&oacute;n</button>
        </div>
    </div>
    
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
    <script type="text/javascript" src="js/app/admin_eval.js"></script>
    <script type="text/javascript">
        $(function(){
            
            var update_nro_preguntas = function(){
                //console.log("blur!!!");
                var basico = $("#txt-nropreguntas-1").val() * 1;
                var intermedio = $("#txt-nropreguntas-2").val() * 1;
                var avanzado = $("#txt-nropreguntas-3").val() * 1;
                $("#txt-nropreguntas").val(basico + intermedio + avanzado);
            };
            
            function validar_formulario(){
                var error = 0;
                $("input[required]").each(function(){
                    if($(this).val() === ""){
                        error++;                        
                    }
                });
                if(error>0){
                    alert("Debe llenar los campos obligatorios");
                    return false;
                }
                
                if($("input[name=rb_tipoevaluacion]:checked").size() === 0){
                    alert("Debes seleccionar un tipo de evaluacion");
                    return false;
                }
                if($("input[name=rb-trimestre]:checked").size() === 0){
                    alert("Debes seleccionar un trimestre");
                    return false;
                }
                return true;
            }
            
            $("#txt-nropreguntas-1, #txt-nropreguntas-2, #txt-nropreguntas-3").blur(update_nro_preguntas).change(update_nro_preguntas);
            $("#form-generarevaluacion").submit(function(evt){
                evt.preventDefault();
                
                if(!validar_formulario()){
                    alert("Debe llenar los campos obligatorios del formulario!");
                    return false;
                }
                
                var $formulario = $(this);                
                $("#txt-encabezado").val($("input:radio:checked").data("label"));
                $.post(
                    $formulario.attr("action"),
                    $formulario.serialize(),
                    function(data){
                        render_table(data);
                    },
                    'json'
                );                
            });
            
            function render_table(data){
                if(data.preguntas){
                    var tpl = '<ol>';
                    //var alt_num = ["A", "B", "C", "D", "E", "F"];
                    $.each(data.preguntas, function(idx, el){
                        tpl += '<li>';
                        tpl += '<p>'+el.enunciado+'</p><br/>';
                        tpl += '<ol>';
                        $.each(el.alternativas.alternativas, function(myidx, myel){
                            tpl += '<li>'+myel.valor+'</li>';
                        });
                        tpl += '</ol>';
                        tpl += '<br/><br/>';
                        tpl += '</li>';
                    });
                    tpl += '</ol>';
                    $("#render-eval").html(tpl);
                }else{
                    alert("Error");
                }
            }
            
            $("#form-vistaprevia").submit(function(evt){            
                if(!validar_formulario()){                    
                    return false;
                }                
                return true;
            });
            
            $("#tabla-preguntas tbody tr").live("click", function(){
                var $this = $(this);
                $this.toggleClass("info");
            });
            
            $("#btn-generar-evaluacion").click(function(){
                var ids = [];
                $("#tabla-preguntas tbody tr.info").each(function(){
                    var $this = $(this);
                    ids.push($this.data("item"));
                });
                
                $.post(
                    'admin_eval.php?action=getSelectedQuestions',
                    {
                        'ids[]':ids
                    },
                    function(data){                        
                        render_table(data);
                        $('#modalPreguntas').modal('hide');
                    },
                    'json'
                );
            });
            
            $('[data-toggle="modal"]').click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                if (url.indexOf('#') === 0) {
                    $(url).modal('open');
                } else {
                    $("input[type=number]").val("0");
                    if(!validar_formulario()){
                        alert("Debe llenar los campos obligatorios del formulario!");
                        return;
                    }
                    var data = $("#form-generarevaluacion").serialize();
                    $.post(url, data, function(data) {
                        var tpl = '';
                        tpl += '<table class="table table-bordered table-striped table-hover" id="tabla-preguntas">';
                        tpl += '    <colgroup>';
                        tpl += '        <col width="50"/>';
                        tpl += '        <col/>';
                        tpl += '    </colgroup>';
                        tpl += '    <thead>';
                        tpl += '        <tr>';
                        tpl += '            <th>#</th>';
                        tpl += '            <th>Enunciado</th>';
                        tpl += '            <th>Dificultad</th>';
                        tpl += '        </tr>';
                        tpl += '    </thead>';
                        tpl += '    <tbody>';
                        $.each(data.preguntas, function(idx, el){
                            tpl += '        <tr data-item="'+el.cod_pregunta+'">';
                            tpl += '            <td>'+(idx+1)+'</td>';
                            tpl += '            <td>'+el.enunciado+'</td>';
                            tpl += '            <td>'+el.obj_niveldificultad.niveldificultad+'</td>';
                            tpl += '        </tr>';                            
                        });
                        tpl += '    </tbody>';
                        tpl += '</table>';
                        
                        var $modal = $("#modalPreguntas");
                        $modal.find("div.modal-body").html(tpl);
                        $modal.modal();
                    }, 'json');
                }
            });
        });
    </script>
</body>
</html>