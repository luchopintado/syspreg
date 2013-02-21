<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a href="#" class="brand">SYSPREG</a>
            <div class="nav-collapse collapse">                
                <ul class="nav">
                    <?php if(!isset($_SESSION["username"])): ?>
                        <li class="active"><a href="#">Inicio</a></li>
                        <li><a href="#about">Acerca de</a></li>
                        <li><a href="#contact">Contacto</a></li>
                    <?php else: ?>
                        <?php if($_SESSION["menu"] === "academico"): ?>
                            <li class="active"><a href="admin.php">Administrador</a></li>
                            <li><a href="admin_eval.php">Evaluaciones</a></li>                    
                        <?php elseif($_SESSION["menu"] === "evaluaciones"): ?>
                            <li><a href="admin.php">Administrador</a></li>
                            <li class="active"><a href="admin_eval.php">Evaluaciones</a></li>                    
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                
                <?php if(isset($_SESSION["username"])): ?>        
                <ul class="nav pull-right">
                    <li id="fat-menu" class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Logueado como <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">         
                            <li><a href="#">Perfil</a></li>
                            <li class="divider"></li>
                            <li><a href="admin.php?action=logout"><i class="icon-off"></i> Salir</a></li>                            
                        </ul>
                    </li>
                </ul>                
                <?php else: ?>
                <p class="navbar-text pull-right">
                    Bienvenido
                </p>
                <?php endif; ?>                    
            </div>
        </div>            
    </div>
</div>