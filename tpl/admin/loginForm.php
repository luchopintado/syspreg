<?php include TEMPLATE_PATH . '/inc/top.php';?>
<body>
    
    
    
    <div class="container">
     
        
        <div id="main" role="main">
            
            <div class="wrap-form">
                <div class="row thumbnails">
                <div class="span4 thumbnail">
                
                <form action="admin.php?action=login" method="post" class="form-horizontal">
                    <legend>Iniciar Sesi&oacute;n</legend>
                    
                    <?php if(isset($results["errorMessage"])): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b>Error</b>: <?php echo $results["errorMessage"]; ?>
                    </div>
                    <?php endif; ?>

                    <div class="control-group">
                        <label for="txt-username" class="control-label">Usuario:</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-user"></i></span>
                                <input type="hidden" name="login" value="true"/>
                                <input class="input-medium" type="text" name="username" id="txt-username" placeholder="Nombre de usuario" required="required" autofocus="true" maxlength="20"/>                        
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="txt-password" class="control-label">Contrase&ntilde;a:</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-lock"></i></span>
                                <input class="input-medium" type="password" name="password" id="txt-password" placeholder="Contrase&ntilde;a" required="required"/>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox"> Recordarme
                             </label>
                            <button type="submit" name="login" class="btn btn-primary "><i class="icon-lock icon-white"></i> Login</button>                        
                        </div>
                    </div>
                </form>            
                </div>
                </div>
            </div>
            
            
        </div>
        
    </div>
    
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
</body>
</html>