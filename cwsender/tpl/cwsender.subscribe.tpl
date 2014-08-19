<!-- BEGIN: MAIN -->

<form action="{SUBS_ID|cot_url('cwsender', 'm=subscribe&a=send&id='$this)}" method="post">
	<input type="text" name="rname" class="form-control" placeholder="Name">
	<input type="text" name="remail" class="form-control" placeholder="Email">
	<button class="btn btn-lg btn-primary btn-block" type="submit">{PHP.L.Submit}</button>
</form>
				
<!-- END: MAIN -->