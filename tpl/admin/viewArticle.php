<?php include TEMPLATE_PATH . '/inc/top.php';?>
<body>
    
    <?php include TEMPLATE_PATH . '/inc/nav.php';?>
    
    <div class="container">
     
        
        <div id="main" role="main">
           
            <div class="page-header">
                <h1><?php echo $results["pageTitle"]; ?></h1>                
            </div>
            
            <div>
                <a href="./admin.php" class="">Volver</a>
                <h3><?php echo $results["article"]->title; ?></h3>
                <strong>Publicado el <?php echo $results["article"]->publication_date ? date("Y-m-d", $results["article"]->publication_date) : "";?></strong>                
                <p class="summary"><?php echo htmlspecialchars($results["article"]->summary); ?></p>                
                <div class="content"><?php echo $results["article"]->content; ?></div>
                <br/>
                <a href="./admin.php" class="">Volver</a>
            </div>
                        

        </div>
        
    </div>
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
</body>
</html>