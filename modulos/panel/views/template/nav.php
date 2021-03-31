<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			 <a class="navbar-brand visible-print" href="#" id="name_empresa"></a>
		</div>
	
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">

		   <ul class="nav navbar-nav navbar-left">
		  	 <li class="dropdown"><a href="<?php echo base_url(); ?>"><b><i class="fa fa-home" aria-hidden="true"></i> Inicio</b></a></li>		
		   </ul>

    	  <ul class="nav navbar-nav navbar-left" id="nav_modulos">
    	  	
    	  </ul>

		  <ul class="nav navbar-nav navbar-right">
           		<li class="dropdown">
	            <a href="#" class="dropdown-toggleclear" data-toggle="dropdown" id="name_persona"> </a>
	            <ul class="dropdown-menu animated fadeInRight">            
		              <li>
		                   <span class="arrow top"></span>
		                   <a href="javascript:void(0)"><i class="fa fa-user-o" aria-hidden="true"></i> Mi perfil</a>
		              </li>
		              <li class="divider"></li>
		              <li>
		                <a href="<?php echo base_url(); ?>panel/salir"><i class="fa fa-share-square-o" aria-hidden="true"></i> Cerrar sesión</a>
		              </li>
		          </ul>
          		</li>
			</ul>
		</div>
		</div>
		<!-- /.navbar-collapse -->
	</nav>