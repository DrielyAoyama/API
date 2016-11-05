<?php $__env->startSection('titulo','Dashboard'); ?>


<?php $__env->startSection('conteudo'); ?>
	<!-- <h1>TEMPLATE PRINCIPAL</h1> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.principal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>