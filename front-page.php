<?php get_header(); ?>

<?php get_template_part('loop', 'page'); ?>

<?php get_template_part('inc/featured_projects'); ?>

<?php get_template_part('inc/finished_movies'); ?>

<?php get_template_part('inc/finished_series'); ?>

<script>
	document.addEventListener("DOMContentLoaded", function(event) { 
		const vMoreBtn    = document.querySelectorAll('.w-more');
		var x = 0;
		//const allFinished = document.querySelectorAll('.finished-project-featured');
		var limit = 15;
		
		for (const b of vMoreBtn) {
			b.addEventListener('click', (event) => {
				allFinished = b.closest('.list').querySelectorAll('.finished-project-featured');
				
				isOpen = b.dataset.showmore;
				type   = b.dataset.pageType;
				
				if(type =='mlab_finished_series'){
					limit = 7;
				}else{
					limit = 15;
				}
				
				console.log(type);
				if(isOpen == ''){
					for (const a of allFinished) {
						a.classList.remove('d-none');
					}
					b.innerHTML = 'SHOW LESS';
					b.dataset.showmore = 'true';
				}else{
					for (const a of allFinished) {
						if(x > limit) a.classList.add('d-none');
						x++;
					}
					b.innerHTML = 'SHOW MORE';
					b.dataset.showmore  = '';
				}
				
			});
		}
	});
</script>

<?php get_footer(); ?>
