<!-- BEGIN: MAIN -->

<!-- BEGIN: SUBSCRIBE -->
	<h1>{PHP.L.cwsender_subscribe_title} "{SUBS_TITLE}"</h1>
	
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	
	<!-- IF {PHP.status} == 'sent' -->
	<div class="alert alert-success">{PHP.L.cwsender_subscribe_status_sent}</div>
	<!-- ENDIF -->
	
	{PHP.id|cwsender_subscribe($this)}
		
<!-- END: SUBSCRIBE -->
				
<!-- END: MAIN -->