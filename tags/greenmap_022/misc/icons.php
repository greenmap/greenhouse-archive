<?php
require_once '../includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
?>



	<fieldset class="collapsible collapsed">
		<legend><span class="categorization">Category:</span>  
			<?php $tid = '147';  // insert the correct id for the term you want to show as the title of this category.
			$cattitle = taxonomy_get_term($tid);  
			print $cattitle -> name; ?> 
		</legend>
		
		<?php $myview = views_get_view(129);
		$myview_args->args[0] = $tid;
		print views_build_view('block', $myview, $myview_args->args, false, 30);
		
//		print_r ($myview_args);
		?>
		
	</fieldset>
	
	
	<fieldset class="collapsible collapsed">
		<legend><span class="categorization">Category:</span>  
			<?php $tid = '151';  // insert the correct id for the term you want to show as the title of this category.
			$cattitle = taxonomy_get_term($tid);  
			print $cattitle -> name; ?> 
		</legend>
		
		<?php $myview = views_get_view(129);		$myview_args->args[0] = $tid;
		print views_build_view('block', $myview, $myview_args->args, false, 30);
		
//		print_r ($myview_args);
		?>
		
	</fieldset>
	
	<fieldset class="collapsible collapsed">
		<legend><span class="categorization">Category:</span>  
			<?php $tid = '156';  // insert the correct id for the term you want to show as the title of this category.
			$cattitle = taxonomy_get_term($tid);  
			print $cattitle -> name; ?> 
		</legend>
		
		<?php $myview = views_get_view(129);		$myview_args->args[0] = $tid;
		print views_build_view('block', $myview, $myview_args->args, false, 30);
		?>
		
	</fieldset>
	
	<fieldset class="collapsible collapsed">
		<legend><span class="categorization">Category:</span>  
			<?php $tid = '153';  // insert the correct id for the term you want to show as the title of this category.
			$cattitle = taxonomy_get_term($tid);  
			print $cattitle -> name; ?> 
		</legend>
		
		<?php $myview = views_get_view(129);		$myview_args->args[0] = $tid;
		print views_build_view('block', $myview, $myview_args->args, false, 30);
		?>
		
	</fieldset>
	
	
	
	<fieldset class="collapsible collapsed">
		<legend><span class="categorization">Category:</span>  
			<?php $tid = '148';  // insert the correct id for the term you want to show as the title of this category.
			$cattitle = taxonomy_get_term($tid);  
			print $cattitle -> name; ?> 
		</legend>
		
		<?php $myview = views_get_view(129);		$myview_args->args[0] = $tid;
		print views_build_view('block', $myview, $myview_args->args, false, 30);
		?>
		
	</fieldset>
	
	
	
	
	
	