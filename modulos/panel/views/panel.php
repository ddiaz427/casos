<ol class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">Panel</a></li>  
  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>  
</ol>
<div class="col-xs-12 col-lg-6">
       <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-user"></i> Mi Perfil                
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget" href="#widget">
                   <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget">
              <div class="panel-body" id="profile_w">

              </div>
         </div>
      </div>
  </div>    

  <div class="col-xs-12 col-lg-6">    
     <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-cog" aria-hidden="true"></i> Configuraciones           
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget2" href="#widget2">
                      <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget2">
              <div class="panel-body" id="empresa_w">
           
              </div>
         </div>
      </div>
    </div>

    <div class="col-xs-12 col-lg-6">
       <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-balance-scale"></i> Casos Creados Hoy <span class="badge" id="totalcasoshoy"></span>               
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget5" href="#widget5">
                     <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget5">
              <div class="panel-body">
                <table class="table table-bordered">
                    <thead class="active">
                          <tr>
                            <th class="text-center">Nombre Caso</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Tipo Caso</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Creado</th>
                          </tr>
                    </thead>
                      <tbody  id="casoshoy">

                      </tbody>
                    </table>  
              </div>
         </div>
      </div>
  </div>    

  <div class="col-xs-12 col-lg-6">    
     <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-balance-scale"></i> Casos Creados en la Semana <span class="badge" id="totalcasossemana"></span>      
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget6" href="#widget6">
                   <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget6">
              <div class="panel-body">
                    <table class="table table-bordered">
                    <thead class="active">
                          <tr>
                            <th class="text-center">Nombre Caso</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Tipo Caso</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Creado</th>
                          </tr>
                    </thead>
                      <tbody id="casossemana">

                      </tbody>
                    </table>  
              </div>
         </div>
      </div>
  </div>


  <div class="col-xs-12 col-lg-6">
       <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-balance-scale"></i> Ultimos Casos Registrados el Mes <span class="badge" id="totalcasosmes"></span>              
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget3" href="#widget3">
                      <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget3">
              <div class="panel-body">
                 <table class="table table-bordered">
                    <thead class="active">
                          <tr>
                            <th class="text-center">Nombre Caso</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Tipo Caso</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Creado</th>
                          </tr>
                    </thead>
                      <tbody id="casosmes">

                      </tbody>
                    </table>  
              </div>
         </div>
      </div>
  </div>

  <div class="col-xs-12 col-lg-6">
       <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-balance-scale"></i> Ultimos Casos Registrados el Año <span class="badge" id="totalcasosanio"></span>              
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget7" href="#widget7">
                      <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget7">
              <div class="panel-body">
                 <table class="table table-bordered">
                    <thead class="active">
                          <tr>
                            <th class="text-center">Nombre Caso</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Tipo Caso</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Creado</th>
                            <th class="text-center">Días Transcurridos</th>
                          </tr>
                    </thead>
                      <tbody id="casosanio">

                      </tbody>
                    </table>  
              </div>
         </div>
      </div>
  </div>

<div class="col-xs-12 col-lg-12">    
     <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
         <div class="panel-heading" id="accordion">
              <i class="fa fa-users"></i> Mis Ultimos Clientes Registrados         
              <div class="btn-group pull-right" style="margin-top: -4px">
                   <a type="button" class="btn btn-raised btn-danger btn-xs" data-toggle="collapse" data-parent="#widget4" href="#widget4">
                      <i class="glyphicon glyphicon-minus"></i>
                   </a>
              </div>
         </div>
         <div class="panel-collapse collapse in" id="widget4">
              <div class="panel-body" id="list_clientes">
           
              </div>
         </div>
      </div>
</div>      	                 