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

                        <p><span class="label label-info"><?php echo $results["totalRows"]; ?> curso<?php echo $results["totalRows"]!=1 ? 's' : '';?> en total.</span></p>
                    
                        <table class="table table-bordered table-striped" id="listado-cursos">
                                <colgroup>
                                    <col width="50"/>
                                    <col/>
                                    <col/>
                                    <col width="120"/>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Grado</th>
                                        <th>Curso</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0;?>
                                    <?php foreach ($results["cursogrados"] as $cg): ?>
                                    <tr data-item="<?php echo $cg->cod_curso; ?>-<?php echo $cg->cod_grado?>">
                                        <td><?php echo ++$i; ?></td>
                                        <td><?php echo $cg->obj_grado->grado; ?></td>
                                        <td><?php echo $cg->obj_curso->curso; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="admin.php?action=viewCursoGrado&cod_curso=<?php echo $cg->cod_curso;?>&cod_grado=<?php echo $cg->cod_grado?>" class="btn btn-mini" title="Ver"><i class="icon-eye-open"></i></a>                                                
                                                <a href="admin.php?action=deleteCursoGrado&cod_curso=<?php echo $cg->cod_curso;?>&cod_grado=<?php echo $cg->cod_grado?>" class="btn btn-mini" title="Eliminar" onclick="return confirm('Confirma eliminaci&oacute;n del registro?');"><i class="icon-remove"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                           
                
                        <div class="row-fluid" style="margin-top: 10px;">
                            <p class="pull-right"><a class="btn btn-primary" href="admin.php?action=newCursoGrado"><i class="icon-plus-sign icon-white"></i> Nueva asignaci&oacute;n</a></p>
                        </div>
                    </div>
                </div>
            </div>
            
            

        </div>
        
    </div>
    <?php include TEMPLATE_PATH . '/inc/footer.php';?>
    <?php include TEMPLATE_PATH . '/inc/scripts.php';?>
    
    <script type="text/javascript" src="js/vendor/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/vendor/DT_bootstrap.js"></script>
    <script type="text/javascript">        
        $(function(){
            $("#listado-cursos").dataTable({
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r><'row-fluid'<'span12't>r><'row-fluid'<'span6'i><'span6'p>>"
            });
        
            $.extend( $.fn.dataTableExt.oStdClasses, {
                "sWrapper": "dataTables_wrapper form-inline"
            } );
        });
    </script>
</body>
</html>