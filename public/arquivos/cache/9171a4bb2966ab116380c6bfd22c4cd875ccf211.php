<?php $__env->startSection('titulo','Login'); ?>


<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

	function logar()
	{
		var email = $('#txtemail').val();
		var senha   = $('#txtsenha').val();
		$.post("<?php echo e(asset('usuarios/logar')); ?>", { email:email,senha:senha})
		.done(function( data ) 
		{
			window.location.href = "<?php echo e(asset('')); ?>";
		},'json');
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>