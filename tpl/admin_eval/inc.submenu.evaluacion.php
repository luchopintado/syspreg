<?php $submenu = array(
    
    new Menu(array("indice"=>"generar",       "nombre"=>"Generar Evaluaci&oacute;n",   "url"=>"./admin_eval.php?action=generarEvaluacion")),
    new Menu(array("indice"=>"listar",    "nombre"=>"Ex&aacute;menes Anteriores",      "url"=>"./admin_eval.php?action=listExamenes"))
);?>

<div class="well sidebar-nav">
    <ul class="nav nav-list">
        <li class="nav-header">Evaluaciones</li>
        
        <?php foreach ($submenu as $sm): ?>
            <li <?php echo $results["indice"]==$sm->indice? 'class="active"':''?>><a href="<?php echo $sm->url?>"><?php echo $sm->nombre; ?></a></li>
        <?php endforeach; ?>
 
    </ul>
</div>