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
                            <h1>Ingresar pregunta</h1>                
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

                        <form action="admin_eval.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal eval-form" id="form-pregunta">
                            <legend>Generales</legend>
                            <div class="control-group">
                                <label for="cmb-nivel" class="control-label">Nivel de estudios:</label>
                                <div class="controls">
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
                                <label for="cmb-tema" class="control-label">Tema:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-tema" name="id_tema" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-subtema" class="control-label">Subtema (Opcional):</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-subtema" name="id_subtema" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            
                            <legend>Nivel de dificultad</legend>
                            <div class="control-group">
                                
                                <div class="controls">      
                                    <?php $nivelesdificultad = NivelDificultad::getList();?>
                                    <?php foreach ($nivelesdificultad["nivelesdificultad"] as $nd): ?>
                                    <label class="radio inline">
                                        <input type="radio" value="<?php echo $nd->cod_niveldificultad; ?>" name="cod_niveldificultad"> <?php echo $nd->nivel;?>
                                    </label>                                    
                                    <?php endforeach; ?>
                                </div>
                            </div>
                                                        
                            
                            <legend>Enunciado</legend>                                
                            <div class="control-group">
                                <textarea id="editor-enunciados" name="enunciado" class="span24 editor"></textarea>
                            </div>
                                                        
                            
                            <legend>Alternativas</legend>                                
                            <div class="control-group">
                                <textarea id="editor-alternativas" class="span24"></textarea>
                                <label class="checkbox">
                                    <input type="checkbox" id="chk-correcta"> Es la alternativa correcta?
                                </label>
                            </div>
                            <div class="control-group">
                                <button type="button" name="saveChanges" value="Guardar Cambios" class="btn" id="btn-add-alternative"><i class="icon-plus-sign"></i> Agregar alternativa</button>                        
                            </div>
                            
                            <div class="control-group">
                                <ol class="alternativas">
                                    <li class="well well-small">
                                        5x+6y-7z=10
                                        <input  type="hidden" name="alt[]" value="5x+6y-7z=10"/>
                                        <input  type="hidden" name="resp[]" value="false"/>                                        
                                        <i class="icon-remove-circle pull-right"></i>
                                    </li>
                                    <li class="well well-small">
                                        5x+6y-7z=10
                                        <input  type="hidden" name="alt[]" value="5x+6y-7z=10"/>
                                        <input  type="hidden" name="resp[]" value="false"/>
                                        <i class="icon-remove-circle pull-right"></i>
                                    </li>
                                    <li class="well well-small label-info">
                                        5x+6y-7z=10
                                        <input  type="hidden" name="alt[]" value="5x+6y-7z=10"/>
                                        <input  type="hidden" name="resp[]" value="true"/>
                                        <i class="icon-ok-circle icon-white pull-right"></i>
                                    </li>
                                    <li class="well well-small">
                                        5x+6y-7z=10
                                        <input  type="hidden" name="alt[]" value="5x+6y-7z=10"/>
                                        <input  type="hidden" name="resp[]" value="false"/>
                                        <i class="icon-remove-circle pull-right"></i>
                                    </li>                                    
                                </ol>                               
                            </div>
                            
                            <div class="control-group">
                                <div class="controls pull-right">
                                    <input type="hidden" id="hdn-codpregunta" name="cod_pregunta" value=""/>
                                    <button type="submit" name="saveChanges" value="Guardar Cambios" class="btn btn-primary ">Guardar pregunta</button>                        
                                </div>
                            </div>

                        </form>
                                                
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
    <script type="text/javascript" src="js/app/admin_eval.js"></script>
    
    <link rel="stylesheet" href="css/prettify.css" />    
    <link rel="stylesheet" href="js/vendor/wysihtml5/bootstrap-wysihtml5.css" />
    <script src="js/vendor/wysihtml5/wysihtml5-0.3.0.min.js"></script>
    <script src="js/vendor/wysihtml5/prettify.js"></script>
    <script src="js/vendor/wysihtml5/bootstrap-wysihtml5.js"></script>
    <script src="js/vendor/wysihtml5/locales/bootstrap-wysihtml5.es-AR.js"></script>
        
    <script>
            $('.editor').wysihtml5({locale: "es-AR"});
    </script>
    
    <script type="text/javascript">
        $(function(){
            var $form = $("#form-pregunta");
            $form.submit(function(evt){
                if($("input:radio:checked").size() === 0){
                    alert("Debes seleccionar un nivel de dificultad");
                    return false;
                }
                
                $.post(
                    $form.attr("action"),
                    $form.serialize(),
                    function(data){
                        if(data.success){
                            alert("Pregunta guardada correctamente!");
                        }else{
                            alert("Error guardando pregunta");
                        }
                    },
                    'json'
                );
                return false;
            });
            
            $("#btn-add-alternative").click(function(){
                var $ol = $("ol.alternativas");
                
                if($ol.children("li").size() >= 5){
                    alert("Se alcanzo el maximo numero de alternativas!");
                    return;
                }
                var enunciado_alternativa = $("#editor-alternativas").val();
                var es_correcta = $("#chk-correcta:checked").size() === 1 ? true:false;
                var icon_class = es_correcta? 'icon-ok-circle icon-white':'icon-remove-circle';
                var li_class = es_correcta? 'label-info':'';
                $ol.append('<li class="well well-small '+li_class+'">'+enunciado_alternativa+'<input  type="hidden" name="alt[]" value="'+enunciado_alternativa+'"/><input  type="hidden" name="resp[]" value="'+es_correcta+'"/><i class="'+icon_class+' pull-right"></i></li>');
            });
        });
    </script>
</body>
</html>