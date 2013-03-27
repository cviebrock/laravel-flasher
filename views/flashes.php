<?php

if ( $flash = Session::get('flash') ) {

	$type = key(reset($flash));
	$msg = $flash

}

foreach( array('error','success','info','warning') as $flash_type ) {
	if (Session::has($flash_type)) {

?>

<div id="flash">
	<div class="flash-inner alert-<?php echo $flash_type; ?>">
		<a class="close" href="#"><i class="icon-remove"></i></a>
		<?php echo Session::get($flash_type); ?>
	</div>
</div>

<script type="text/javascript">
$(function() {
	var $f = $('#flash'), $c = $('a.close',$f);
	$c.on('click',function() {
		$f.fadeOut(1000);
	});
	window.setTimeout(function() { $c.click(); }, <?php echo $flash_type=='error' ? 10000 : 4000; ?>);
});
</script>

<?php

		break;
	}
}

