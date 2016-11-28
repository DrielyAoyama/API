<?php

class Script 
{
	
	public function set($url)
	{
		// echo $url;exit();
		if(file_exists($url))
			return "
<script>
".file_get_contents($url)."
</script>";
	}

	
}