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
                            <h3><small>Bienvenidos a la secci&oacute;n de mantenimiento de Areas</small></h3>
                            <p>
                                Para ingresar una nueva &aacute;rea utilice el formulario a continuaci&oacute;n que le indicar&aacute; los campos que debe llenar.
                            </p>
                            <?php endif; ?>
                        </div>            

                        <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal">

                            <div class="control-group">
                                <label for="txt-areas" class="control-label">Nombre del area:</label>
                                <div class="controls">
                                    <input type="hidden" name="cod_area" value="<?php echo $results["area"]->cod_area; ?>"/>
                                    <input type="text" class="input-xxlarge" name="areas" id="txt-area" placeholder="Nombre de esta area" value="<?php echo htmlspecialchars($results["area"]->areas);?>"/>                        
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">                            
                                    <button type="submit" name="saveChanges" value="Guardar Cambios" class="btn btn-primary ">Guardar Cambios</button>                        
                                    <button type="submit" formnovalidate name="cancel" class="btn">Cancelar</button>
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