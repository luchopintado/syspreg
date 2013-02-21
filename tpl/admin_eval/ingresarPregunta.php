<?php include TEMPLATE_PATH . '/inc/top.php';?>
<body>
    
    <?php include TEMPLATE_PATH . '/inc/nav.php';?>
    
    <div class="container">
     
        
        <div id="main" role="main">
           
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span3">
                        <?php include TEMPLATE_PATH . '/admin/inc.submenu.academico.php';?>
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

                        <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal eval-form" id="form-pregunta">
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
                            
                            <legend>Tipo de Pregunta</legend>
                            <div class="control-group">
                                <div class="controls">
                                    <?php $tipoevaluaciones = TipoEvaluacion::getList();?>
                                    <?php foreach ($tipoevaluaciones["tipoevaluaciones"] as $te): ?>
                                    <label class="radio inline">
                                        <input type="radio" data-label="<?php echo $te->tipoevaluacion; ?>" name="id_tipopregunta" value="<?php echo $te->cod_tipoevaluacion; ?>"> <?php echo $te->tipoevaluacion; ?>
                                    </label>                                    
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <legend>Nivel de dificultad</legend>
                            <div class="control-group">
                                
                                <div class="controls">      
                                    <?php $nivelesdificultad = NivelDificultad::getList();?>
                                    <?php foreach ($nivelesdificultad["nivelesdificultad"] as $nd): ?>
                                    <label class="radio inline">
                                        <input type="radio" value="<?php echo $nd->cod_niveldificultad; ?>" name="cod_niveldificultad"> <?php echo $nd->niveldificultad;?>
                                    </label>                                    
                                    <?php endforeach; ?>
                                </div>
                            </div>
                                                        
                            
                            <legend>Enunciado
                                <a href="#modalEnunciado" id="btn-editar-enunciado" role="button" class="btn pull-right" data-toggle="modal">Editar Enunciado</a>
                            </legend>                                
                            <div class="control-group">                                
                                <div id="render-enunciado"></div>
                                <input type="hidden" name="enunciado" id="hdn-enunciado" value=""/>
                            </div>
                                                        
                            
                            <legend>Alternativas
                                <a href="#modalEnunciado" id="btn-editar-alternativa" role="button" class="btn pull-right" data-toggle="modal">Editar alternativa</a>
                                <!--a href="#modalAlternativa" role="button" class="btn pull-right" data-toggle="modal">Editar alternativa</a-->
                            </legend>                                
                            <div class="control-group">                                
                                <div id="render-alternativa"></div>
                                
                                    <label class="checkbox inline">
                                        <input type="checkbox" id="chk-correcta" value=""/> Es correcta?                                        
                                    </label>
                                
                            </div>
                            <div class="control-group">
                                <button type="button" name="saveChanges" value="Guardar Cambios" class="btn" id="btn-add-alternative"><i class="icon-plus-sign"></i> Agregar alternativa</button>                        
                            </div>
                            
                            <div class="control-group">
                                <ol class="alternativas">
                                                                     
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
    
    <div id="modalEnunciado" class="modal hide fade modal-enunciado" tabindex="-1" role="dialog" aria-labelledby="modalEnunciado" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Editar enunciado</h3>
        </div>
        <div class="modal-body">
            <div class="sharemath">
                <object id="AlfredEq" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="294">
                    <param name="movie" value="alfredeq/AlfredEq_unlicensed.swf" />
                    <param name='allowScriptAccess' value='always' />

                    <!--[if !IE]>-->
                    <object type="application/x-shockwave-flash" data="alfredeq/AlfredEq_unlicensed.swf" width="100%" height="294">
                        <!--<![endif]-->
                        <div>
                            <h1>Alternative content</h1>
                            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                        </div>
                        <!--[if !IE]>-->
                    </object>
                    <!--<![endif]-->
                </object>
            </div>
            <div class="control-group">
                <div class="controls">
                <textarea id="editor-enunciados" name="enunciado" class="editor"></textarea>
                </div>
            </div>                                
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <button class="btn btn-primary" id="btn-listo">Listo</button>
        </div>
    </div>
    
  
    
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
    <script type="text/javascript" src="js/app/admin_eval.js"></script>
    
    <script type="text/javascript" src="alfredeq/swfobject.js"></script>
    <script type="text/javascript">
    swfobject.registerObject("AlfredEq", "11.1.0", "expressInstall.swf");
    </script>
    
    <link rel="stylesheet" href="js/vendor/tinyeditor/tinyeditor.css">
    <script src="js/vendor/tinyeditor/tiny.editor.packed.js"></script>
    <script>
    
    </script>
    
    <script type="text/javascript">
        $(function(){
            var editando;
            
            var editor = new TINY.editor.edit('editor', {
                id: 'editor-enunciados',
                width: '100%',
                height: 100,
                cssclass: 'tinyeditor',
                controlclass: 'tinyeditor-control',
                rowclass: 'tinyeditor-header',
                dividerclass: 'tinyeditor-divider',
                controls: ['bold', 'italic', 'underline', '|', 
                    'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
                    'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', '|', 'image', 'hr', 'n',
                    'font', 'size'],
                footer: true,
                fonts: ['Verdana', 'Arial', 'Georgia', 'Trebuchet MS'],
                xhtml: true,
                cssfile: 'custom.css',
                bodyid: 'editor',
                footerclass: 'tinyeditor-footer',
                toggle: {text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'},
                resize: {cssclass: 'resize'}
            });
        
            var $form = $("#form-pregunta");
            $form.submit(function(evt){
                if($("input[name=cod_niveldificultad]:checked").size() === 0){
                    alert("Debes seleccionar un nivel de dificultad");
                    return false;
                }
                if($("input[name=id_tipopregunta]:checked").size() === 0){
                    alert("Debes seleccionar un tipo de pregunta");
                    return false;
                }
                
                $.post(
                    $form.attr("action"),
                    $form.serialize(),
                    function(data){
                        if(data.success){
                            alert("Pregunta guardada correctamente!");
                            
                            //Borramos todos los campos
                            $form[0].reset();
                            $("#render-enunciado").html("");
                            $("#render-alternativa").html("");
                            $(".tinyeditor div iframe").contents().find("#editor").html("");                            
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
                
                var $render_alternativa = $("#render-alternativa");
                var enunciado_alternativa = $render_alternativa.html();
                
                if(enunciado_alternativa === ""){
                    alert("Debe ingresar un enunciado");
                    return;
                }
                
                var es_correcta = $("#chk-correcta:checked").size() === 1 ? true:false;
                
                if(es_correcta && $ol.find("li>input:hidden[value=true]").size() > 0){
                    alert("Solo una alternativa puede ser correcta!");
                    return;
                }
                
                var li_class = es_correcta? 'label-info':'';
                
                var myhtml = '';
                myhtml += '<li class="well well-small '+li_class+'">';
                myhtml += ' <div class="div-html">'+enunciado_alternativa+'</div>';                
                myhtml += ' <input type="hidden" name="alt[]" value="'+ escape(enunciado_alternativa) +'">';                
                myhtml += ' <input  type="hidden" name="resp[]" value="'+es_correcta+'">';                
                myhtml += ' <a class="close" data-dismiss="alert" href="#">&times;</a>';                
                myhtml += '</li>';
                
                $ol.append(myhtml);
                $render_alternativa.html("");
            });
            
            $("#btn-listo").click(function(){
                var $editor = $(".tinyeditor div iframe").contents().find("#editor");
                var contents = $editor.html();
                if(editando==="enunciado"){
                    
                    $("#render-enunciado").html(contents);
                    $("#hdn-enunciado").val(escape(contents));
                }else{
                    if(editando==="alternativa"){
                        
                        $("#render-alternativa").html(contents);
                    }
                }
                $('#modalEnunciado').modal('hide');
                $editor.html("");
            });
            
            $("#btn-editar-alternativa").click(function(){
                editando="alternativa";
                $("#myModalLabel").html("Editar enunciado de la alternativa");
                
                var contenido_render = $("#render-alternativa").html();
                if(contenido_render !== ""){
                    var $editor = $(".tinyeditor div iframe").contents().find("#editor");
                    $editor.html(contenido_render);
                }
            });
            $("#btn-editar-enunciado").click(function(){
                editando="enunciado";
                $("#myModalLabel").html("Editar enunciado de la pregunta");
                
                var contenido_render = $("#render-enunciado").html();
                if(contenido_render !== ""){
                    var $editor = $(".tinyeditor div iframe").contents().find("#editor");
                    $editor.html(contenido_render);
                }
            });
        });
    </script>
</body>
</html>