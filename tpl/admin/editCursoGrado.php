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
                            <h1><?php echo $results["pageTitle"]; ?></h1>                           
                            <?php if(!isset($results["formAction"])): ?>
                                <h3><small>Bienvenidos a la secci&oacute;n de asignacion de Cursos y Grados</small></h3>
                                <p>
                                    Para asignar un curso a un grado utilice el formulario a continuaci&oacute;n que le indicar&aacute; los campos que debe llenar.
                                </p>
                            <?php endif; ?>
                        </div>            

                        <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal">
                            <legend>Grado</legend>
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
                                <label for="cmb-grado" class="control-label"><strong>Grado:</strong></label>
                                <div class="controls">                                    
                                    <select class="input-xxlarge" id="cmb-grado" name="cod_grado" required="required">
                                        <option value="0">Seleccionar...</option>                                        
                                    </select>                                    
                                </div>
                            </div>
                            <legend>Curso</legend>
                            <div class="control-group">
                                <label for="cmb-area" class="control-label">Area:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-area" name="cod_area" required="required">
                                        <option value="0">Seleccionar...</option>
                                        <?php $areas = Area::getList();?>
                                        <?php foreach ($areas["areas"] as $area): ?>
                                            <?php if($results["curso"]->cod_area === $area->cod_area): ?>
                                            <option selected="selected" value="<?php echo $area->cod_area?>"><?php echo $area->areas;?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $area->cod_area?>"><?php echo $area->areas;?></option>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="control-group">
                                <label for="cmb-curso" class="control-label"><strong>Curso:</strong></label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-curso" name="cod_curso" required="required">
                                        <option value="0">Seleccionar...</option>
                                    </select>                                    
                                </div>
                            </div>
                            
                            
                            <div class="control-group">
                                <div class="controls">                            
                                    <button type="submit" name="saveChanges" value="Guardar Cambios" class="btn btn-primary ">Asignar</button>                        
                                    <?php if(isset($results["formAction"])): ?>
                                        <button type="submit" formnovalidate name="cancel" class="btn">Cancelar</button>
                                    <?php endif; ?>
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
    
    
    <script type="text/javascript">
        $(function() {
            $("#cmb-nivel").live("change", getGradoByNivel);
            
            $("#cmb-area").live("change", getCursoByArea);
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

        

        function getCursoByArea(){
            var idarea = $("#cmb-area").val() * 1;
            if(idarea === 0){
                return;
            }
            var tpl = '<option value="0">Cargando ...</option>';
            var $combo = $("#cmb-curso");
            $combo.html(tpl).attr("disabled", "true");
            $.post(
                'admin_eval.php?action=getCursoByAreaSimple',
                {            
                    'idarea': idarea
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

        
       
    </script>
    
</body>
</html>