			<footer class="footer" role="contentinfo">
			
                                <div class="hidden" id="loading-div"><img src="<?php echo get_template_directory_uri(); ?>/library/images/10.gif" alt="loading..." /></div>
                            
				<div id="inner-footer" class="clearfix">
					
					<nav role="navigation">
    					<?php bones_footer_links(); ?>
                                        </nav>
	                		
                                    <p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> | Email: <a href="mailto:<?php echo get_bloginfo('admin_email'); ?>" /><?php echo get_bloginfo('admin_email'); ?></a></p>
				
				</div> <!-- end #inner-footer -->
				
			</footer> <!-- end footer -->
		
		</div> <!-- end #container -->
		
		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>

	</body>

</html> <!-- end page. what a ride! -->
