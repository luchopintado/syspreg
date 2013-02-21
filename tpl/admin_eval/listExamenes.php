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
                            <h1>Listar Ex&aacute;menes</h1>                
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

                        <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal eval-form">
                            <legend>Generales</legend>
                            <div class="control-group">
                                <label for="cmb-nivel" class="control-label">Nivel de estudios:</label>
                                <div class="controls">
                                    <input type="hidden" name="cod_evaluacion" value="<?php echo $results["evaluacion"]->cod_evaluacion; ?>"/>
                                    <select class="input-xxlarge" id="cmb-nivel" name="cod_nivel" required="required">
                                        <option value="0">Seleccionar...</option>
                                        <?php $niveles = Nivel::getList();?>
                                        <?php foreach ($niveles["niveles"] as $nivel): ?>
                                            <option value="<?php echo $nivel->cod_nivel?>"><?php echo $nivel->niveldificultad;?></option>                                            
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
                                                        
                            <legend>Rango de Fechas</legend>                                
                            <div class="control-group">
                                <label for="cmb-fechaini" class="control-label">Desde:</label>
                                <div class="controls">
                                    <div class="input-append date" id="cmb-fechaini" name="fechaini" required="required" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input size="16" type="text" value="12-02-2012" readonly>
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cmb-fechafin" class="control-label">Hasta:</label>
                                <div class="controls">
                                    <div class="input-append date" id="cmb-fechafin" name="fechafin" required="required" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input size="16" type="text" value="12-02-2012" readonly>
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>                                    
                                </div>                                
                            </div>
                                                        
                            <div class="control-group">
                                <button type="submit" name="saveChanges" value="Guardar Cambios" class="btn btn-primary "><i class="icon-search icon-white"></i> B&uacute;squeda</button>                        
                            </div>
                        </form>
                        
                        <form action="#" method="post" class="form-horizontal eval-form">
                            <legend>Resultados</legend>                                                            
                            <div class="control-group">
                                
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <p>A&uacute;n no se pueden mostrar resultados.</p>
                                    <p>Utiliza el panel de filtrado para realizar una b&uacute;squeda</p>
                                </div>
                                
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre de Evaluaci&oacute;n</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $i<5; $i++):?>
                                        <tr>
                                            <td>Examen parcial de Matem&aacute;tica: Ecuaciones diferenciales</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="admin.php?action=viewArticle&articleId=" class="btn btn-mini" title="Mostrar Solucionario"><i class="icon-eye-open"></i></a>                                                    
                                                    <a href="admin.php?action=viewArticle&articleId=" class="btn btn-mini" title="Mostrar detalles de la evaluacion"><i class="icon-list"></i></a>                                                    
                                                    <a href="admin.php?action=deleteArticle&articleId=" class="btn btn-mini btn-warning" title="Eliminar" onclick="return confirm('Confirma eliminaci&oacute;n del art&iacute;culo?')"><i class="icon-remove"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endfor;?>
                                    </tbody>
                                </table>
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
    
    <link rel="stylesheet" href="css/datepicker.css" />    
    <script type="text/javascript">
        $(function(){
            $('#cmb-fechaini').datepicker();
            $('#cmb-fechafin').datepicker();
        });
    </script>
</body>
</html>