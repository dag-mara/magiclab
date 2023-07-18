
		<footer class="row site-footer">

			<?php dynamic_sidebar('footer') ?>

		</footer>

		<?php do_action('startup_footer'); ?>

		<?php wp_footer(); ?>

	</div> <!-- .site-wrapper -->

	<script>
	const lazyload = new MiniLazyload({
		threshold: .5,
		rootMargin: "0px",
		onload: image => image.style.border = "10px dashed #000"
	}, ".lazyload");
	</script>
	<script>
	    var ajaxurl = '<?=admin_url('admin-ajax.php')?>?time=<?=time();?>';
	    var url     = '<?=get_stylesheet_directory_uri().'/assets'?>';
	</script>
</body>
</html>
