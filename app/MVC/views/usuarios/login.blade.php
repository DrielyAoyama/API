@extends('templates.login')

@section('titulo','Login')


@section('scripts')
<script type="text/javascript">

	function logar()
	{
		var email = $('#txtemail').val();
		var senha   = $('#txtsenha').val();
		$.post("{{asset('usuarios/logar')}}", { email:email,senha:senha})
		.done(function( data ) 
		{
			window.location.href = "{{asset('')}}";
		},'json');
	}
</script>
@stop