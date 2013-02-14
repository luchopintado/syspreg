<?php $submenu = array(
    new Menu(array("indice"=>"areas",       "nombre"=>"&Aacute;reas",   "url"=>"./admin.php?action=listAreas")),
    new Menu(array("indice"=>"capacidades", "nombre"=>"Capacidades",    "url"=>"./admin.php?action=listCapacidades")),
    new Menu(array("indice"=>"cursos",      "nombre"=>"Cursos",         "url"=>"./admin.php?action=listCursos")),
    new Menu(array("indice"=>"cursosgrados",      "nombre"=>"Asignar Cursos-Grados",         "url"=>"./admin.php?action=listCursosgrados")),
    new Menu(array("indice"=>"temas",       "nombre"=>"Temas",          "url"=>"./admin.php?action=listTemas")),
    new Menu(array("indice"=>"subtemas",    "nombre"=>"Sub Temas",      "url"=>"./admin.php?action=listSubtemas"))
);?>

<div class="well sidebar-nav">
    <ul class="nav nav-list">
        <li class="nav-header">Acad&eacute;mico</li>
        
        <?php foreach ($submenu as $sm): ?>
            <li <?php echo $results["indice"]==$sm->indice? 'class="active"':''?>><a href="<?php echo $sm->url?>"><?php echo $sm->nombre; ?></a></li>
        <?php endforeach; ?>
 
    </ul>
</div>