<?php include TEMPLATE_PATH . '/inc/top.php';?>
<body>
    
    <?php include TEMPLATE_PATH . '/inc/nav.php';?>
    
    <div class="container">
        <div id="main" role="main">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span3">
                        <div class="well sidebar-nav">
                            <ul class="nav nav-list">
                                <li class="nav-header">Acad&eacute;mico</li>
                                <li class="active"><a href="#">&Aacute;reas</a></li>
                                <li><a href="#">Capacidades</a></li>
                                <li><a href="#">Cursos</a></li>
                                <li><a href="#">Tema</a></li>
                                <li><a href="#">Subtema</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="span9">
                        
                        <?php if($results["totalRows"] === 0): ?>
                        <h2>bienvenido</h2>                        
                        <?php else: ?>
                        <?php endif; ?>
                        
                        
                        <div class="page-header">
                            <h1>Todos los art&iacute;culos</h1>                
                        </div>

                        <?php if (isset($results["errorMessage"])): ?>
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <b>Error</b>: <?php echo $results["errorMessage"]; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($results["statusMessage"])): ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <b>Status</b>: <?php echo $results["statusMessage"]; ?>
                            </div>
                        <?php endif; ?>

                        <p><span class="label label-info"><?php echo $results["totalRows"]; ?> art&iacute;culo<?php echo $results["totalRows"] != 1 ? 's' : ''; ?> en total.</span></p>
                        <table class="table table-bordered table-striped">
                            <colgroup>
                                <col width="50"/>
                                <col/>
                                <col/>
                                <col width="100"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Publicado el</th>
                                    <th>Art&iacute;culo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                <?php foreach ($results["articles"] as $article): ?>
                                    <tr data-articleid="<?php echo $article->id; ?>">
                                        <td><?php echo++$i; ?></td>
                                        <td><?php echo date("j M Y", $article->publication_date); ?></td>
                                        <td><?php echo $article->title; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="admin.php?action=viewArticle&articleId=<?php echo $article->id; ?>" class="btn btn-mini" title="Ver"><i class="icon-eye-open"></i></a>
                                                <a href="admin.php?action=editArticle&articleId=<?php echo $article->id; ?>" class="btn btn-mini" title="Editar"><i class="icon-pencil"></i></a>
                                                <a href="admin.php?action=deleteArticle&articleId=<?php echo $article->id; ?>" class="btn btn-mini" title="Eliminar" onclick="return confirm('Confirma eliminaci&oacute;n del art&iacute;culo?')"><i class="icon-remove"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <p class="pull-right"><a class="btn btn-primary" href="admin.php?action=newArticle"><i class="icon-plus-sign icon-white"></i> Agregar nuevo art&iacute;culo</a></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
</body>
</html>