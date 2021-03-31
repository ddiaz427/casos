<?php 
 $usuario_in = array(
              'name'        => 'usuario',
              'id'          => 'usuario',
              'value'       => @set_value('usuario'),
              'class'       => 'form-control',
              'placeholder' => 'Usuario o correo',
            );

$clave = array(
          'name'        => 'clave',
          'id'          => 'password',
          'value'       => @set_value('clave'),
          'class'       => 'form-control',
          'placeholder' => 'Contraseña',
          );

$submit = array(
        'name' => 'button',
        'id' => 'fenviar',
        'value' => 'true',
        'type' => 'submit',
        'content' => 'Iniciar Sesión',
        'class' => 'btn btn-raised btn-default',
    );
 ?>

<div class="container">
    <div class="row">
     <div class="col-md-5" style="float: none; margin: 0 auto; vertical-align:middle;">
        <div class="panel panel-primary login animated fadeInUp">

          <div class="panel-heading"><b>Ingrese sus datos para acceder al Sistema</b></div>
            <div class="panel-body">

              <div id="msj_alert"></div>
                 <?php echo form_open(base_url().'login/checkLogin', array('id' => 'login', 'onsubmit' => 'o_login.submit(); return false;', 'autocomplete' => 'off'));?>  
          
                 <div class="form-group">
                      <div class="col-md-12">
                          <i class="fa fa-balance-scale fa-5x" aria-hidden="true"></i>
                      </div>
                  </div>

                <div class="form-group">
                  <div class="col-md-12">
                      <div class="form-group">
                         <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-user"></i></span>
                           <?php echo form_input($usuario_in); ?>
                        </div>
                      </div>
                      <span class="help-block"></span>
                    </div>

                    <div class="col-md-12">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                           <?php echo form_password($clave); ?>
                         </div>
                        <span class="help-block"></span>
                    </div>
                    
                    <div class="col-md-12">
                            <div class="col-md-12 text-center">
                                <?php echo form_button($submit); ?>
                                <span class="help-block"></span>
                            </div>
                    </div>

                   <div class="col-md-6">
                          <label class="checkbox">
                              <input type="checkbox" name="remember" value='1' checked="checked"><span class="checkbox-material">
                              <span class="check"/>
                              </span> Recordarme
                          </label>
                    </div>

                    <div class="col-md-12 text-center">
                        <label class="checkbox">
                            <a href="javascript:void(0)">¿Olvidaste Tu Contraseña?</a>
                        </label>
                    </div>
                </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
     </div> 
</div>  