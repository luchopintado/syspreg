<?php include TEMPLATE_PATH . '/inc/top.php';?>
<body>
    
    <?php include TEMPLATE_PATH . '/inc/nav.php';?>
    
    <div class="container">
     
        
        <div id="main" role="main">
           
            <div class="page-header">
                <h1><?php echo $results["pageTitle"]; ?></h1>                
            </div>
            
            <form action="admin.php?action=<?php echo $results["formAction"];?>" method="post" class="form-horizontal">
                
                <div class="control-group">
                        <label for="txt-title" class="control-label">T&iacute;tulo del art&iacute;culo:</label>
                        <div class="controls">
                            <input type="hidden" name="articleId" value="<?php echo $results["article"]->id; ?>"/>
                            <input type="text" class="input-xxlarge" name="title" id="txt-title" placeholder="Nombre de este art&iacute;culo" value="<?php echo htmlspecialchars($results["article"]->title);?>"/>                        
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="txt-summary" class="control-label">Resumen del art&iacute;culo:</label>
                        <div class="controls">
                            <textarea class="input-xxlarge" name="summary" rows="4" id="txt-summary" placeholder="Resumen de este art&iacute;culo"><?php echo htmlspecialchars($results["article"]->summary);?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="txt-content" class="control-label">Contenido del art&iacute;culo:</label>
                        <div class="controls">
                            <textarea class="input-xxlarge" name="content" rows="4" id="txt-content" placeholder="Contenido de este art&iacute;culo"><?php echo htmlspecialchars($results["article"]->content); ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="txt-publicationdate" class="control-label">Fecha de publicaci&oacute;n:</label>
                        <div class="controls">
                            <input type="text" name="publication_date" id="txt-publicationdate" placeholder="YYYY-MM-DD" value="<?php echo $results["article"]->publication_date ? date("Y-m-d", $results["article"]->publication_date) : "";?>"/>
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
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
</body>
</html>