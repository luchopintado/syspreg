<?php include 'inc/top.php';?>
<body>
    
    <?php include 'inc/nav.php';?>
    
    <div class="container">
        <header class="hero-unit">
            <h1>Administrador CMS </h1>
            <p>esta es una plantilla de twitter bootstrap</p>
            <p>
                <a class="btn btn-primary btn-large">Visitanos en Facebook</a>
            </p>
        </header>
        
        <div id="main" role="main">
            
            
                        
            <article class="full-article">
                <h1><?php echo htmlspecialchars($results["article"]->title);?></h1>
                <div class="content">
                    <p>
                        <?php echo htmlspecialchars($results["article"]->summary);?>
                    </p>
                    <?php echo $results["article"]->content;?>
                </div>
                <span class="label label-info">Publicado el <?php echo date("d/m/Y", $results["article"]->publication_date);?></span>
                <br/><br/>
                <a href="./" class="">Regresar a la p&aacute;gina de inicio</a>
            </article>
                       
            
        </div>
        
    </div>
    <?php include 'inc/footer.php';?>
    <?php include 'inc/scripts.php';?>
    
</body>
</html>