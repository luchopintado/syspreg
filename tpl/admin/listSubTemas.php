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

                       

                        <p><span class="label label-info"><?php echo $results["totalRows"]; ?> subtema<?php echo $results["totalRows"]!=1 ? 's' : '';?> en total.</span></p>
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
                                    <th>Tema</th>
                                    <th>Subtema</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0;?>
                                <?php foreach ($results["subtemas"] as $subtema): ?>
                                <tr data-item="<?php echo $subtema->id; ?>">
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $subtema->obj_tema->tema; ?></td>
                                    <td><?php echo $subtema->subtema; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="admin.php?action=viewSubtema&cod_subtema=<?php echo $subtema->cod_subtema;?>" class="btn btn-mini" title="Ver"><i class="icon-eye-open"></i></a>
                                            <a href="admin.php?action=editSubtema&cod_subtema=<?php echo $subtema->cod_subtema;?>" class="btn btn-mini" title="Editar"><i class="icon-pencil"></i></a>
                                            <a href="admin.php?action=deleteSubtema&cod_subtema=<?php echo $subtema->cod_subtema;?>" class="btn btn-mini" title="Eliminar" onclick="return confirm('Confirma eliminaci&oacute;n del registro?');"><i class="icon-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <p class="pull-right"><a class="btn btn-primary" href="admin.php?action=newSubtema"><i class="icon-plus-sign icon-white"></i> Agregar nuevo subtema</a></p>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
</body>
</html>