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
                            <h1>Nuevo tema</h1>                           
                            <?php if(!isset($results["formAction"])): ?>
                                <h3><small>Bienvenidos a la secci&oacute;n de mantenimiento de temas</small></h3>
                                <p>
                                    Para ingresar un nuevo tema utilice el formulario a continuaci&oacute;n que le indicar&aacute; los campos que debe llenar.
                                </p>
                            <?php endif; ?>
                        </div>          
                        
                        <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal" id="form-tema">
                            
                            <legend>Trimestre</legend>
                            <div class="controls">
                                    <?php $trimestres = Trimestre::getList();?>
                                    <?php foreach ($trimestres["trimestres"] as $t): ?>
                                    <label class="radio inline">
                                        <input type="radio" data-label="<?php echo $t->trimestre; ?>" name="cod_trimestre" id="rb-cod-trimestre-<?php echo $t->cod_trimestre; ?>" value="<?php echo $t->cod_trimestre; ?>">Trimestre <?php echo $t->trimestre; ?></label>                                    
                                    <?php endforeach; ?>
                            </div>
                            
                            
                            <legend>Grado</legend>
                            
                            <div class="control-group">
                                <label for="cmb-nivel" class="control-label">Nivel de estudios:</label>
                                <div class="controls">                                    
                                    <select class="input-xxlarge" id="cmb-nivel" name="cod_nivel" required="required">
                                        <option value="0">Seleccionar...</option>
                                        <?php $niveles = Nivel::getList();?>
                                        <?php foreach ($niveles["niveles"] as $nivel): ?>
                                            <?php if($results["formAction"]=="editTema"): ?>
                                                <?php if($results["tema"]->obj_grado->obj_nivel->cod_nivel === $nivel->cod_nivel): ?>
                                                <option selected="selected" value="<?php echo $nivel->cod_nivel?>"><?php echo $nivel->nivel;?></option>
                                                <?php else: ?>                                            
                                                <option value="<?php echo $nivel->cod_nivel?>"><?php echo $nivel->nivel;?></option>
                                                <?php endif; ?>
                                            <?php else: ?>
                                            <option value="<?php echo $nivel->cod_nivel?>"><?php echo $nivel->nivel;?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-grado" class="control-label">Grado:</label>
                                <div class="controls">                                    
                                    <select class="input-xxlarge" id="cmb-grado" name="cod_grado" required="required">
                                        <option value="0">Seleccionar...</option>     
                                        <?php if($results["formAction"]=="editTema"): ?>
                                        <option value="<?php echo $results["tema"]->obj_grado->cod_grado;?>" selected="selected"><?php echo $results["tema"]->obj_grado->grado;?></option>     
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                            </div>
                            
                            
                            
                            
                            <legend>Curso</legend>
                            
                             <div class="control-group">
                                <label for="cmb-area" class="control-label">Area:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-area" name="cod_area" required="required">
                                        <option value="0">Seleccionar...</option>
                                        <?php if($results["formAction"]=="editTema"): ?>
                                        <option selected="selected" value="<?php echo $results["tema"]->obj_curso->obj_area->cod_area;?>"><?php echo $results["tema"]->obj_curso->obj_area->areas;?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>    

                            <div class="control-group">
                                <label for="cmb-curso" class="control-label">Curso:</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="cmb-curso" name="cod_curso" required="required">
                                        <option value="0">Seleccionar...</option>
                                        <?php if($results["formAction"]=="editTema"): ?>
                                        <option selected="selected" value="<?php echo $results["tema"]->obj_curso->cod_curso;?>"><?php echo $results["tema"]->obj_curso->curso;?></option>
                                        <?php endif; ?>
                                    </select>                                    
                                </div>
                            </div>
                            
                           
                           

                            <div class="control-group">
                                <label for="txt-tema" class="control-label">Nombre del tema:</label>
                                <div class="controls">
                                    <input type="hidden" name="cod_tema" value="<?php echo $results["tema"]->cod_tema; ?>"/>
                                    <input type="text" class="input-xxlarge" name="tema" id="txt-tema" placeholder="Nombre de este tema" value="<?php echo htmlspecialchars($results["tema"]->tema);?>"/>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls">                            
                                    <button type="submit" name="saveChanges" value="Guardar Cambios" class="btn btn-primary ">Guardar Cambios</button>                        
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
    
    <script type="text/javascript" src="js/app/admin_eval.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#form-tema").submit(function(evt){
                if($("input:radio:checked").size() === 0){
                    alert("Debe seleccionar un trimestre!");
                    return false;                    
                }
            });
        });
    </script>
</body>
</html>