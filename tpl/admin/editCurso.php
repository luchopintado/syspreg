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
                            <h1>Nuevo Curso</h1>                           
                            <?php if(!isset($results["formAction"])): ?>
                                <h3><small>Bienvenidos a la secci&oacute;n de mantenimiento de Cursos</small></h3>
                                <p>
                                    Para ingresar un nuevo curso utilice el formulario a continuaci&oacute;n que le indicar&aacute; los campos que debe llenar.
                                </p>
                            <?php endif; ?>
                        </div>            

                        <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal">

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
                                <label for="txt-curso" class="control-label">Nombre del curso:</label>
                                <div class="controls">
                                    <input type="hidden" name="cod_curso" value="<?php echo $results["curso"]->cod_curso; ?>"/>
                                    <input type="text" class="input-xxlarge" name="curso" id="txt-curso" placeholder="Nombre de este curso" value="<?php echo htmlspecialchars($results["curso"]->curso);?>"/>
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
    
</body>
</html>