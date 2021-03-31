<!DOCTYPE html>
<html lang="es">
	<head>
<title><?php echo $titulo ?></title>
<meta charset="utf-8">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" role="theme">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap-material-design.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bootstrap/css/ripples.min.css">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/animate.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/styles.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/stylestree.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/main.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/pace.css">
 <!--Css Adicionales vienes del controlador-->    
<?php if (isset($cssvista)): ?>
 <?php foreach($cssvista as $css): ?>
 	<link rel="stylesheet" type="text/css" href="<?php echo base_url().$css;?>">
 <?php endforeach; ?>
<?php endif; ?>
<script src="<?php echo base_url();?>assets/js/jquery-3.1.1.min.js"></script>

<script src="<?php echo base_url();?>assets/editor/tinymce/tinymce.min.js"></script>

</head>
	<body>