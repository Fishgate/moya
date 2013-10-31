<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="twelvecol first clearfix" role="main">

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					    <article class="clearfix" id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
						    <header class="article-header">
						
						    </header> <!-- end article header -->
					
						    <section class="entry-content">
							    
						    </section> <!-- end article section -->
     
                                                    <div id="feature-holder">
                                                        <div class="isotope-me" id="welcome">
                                                            <h1><?php the_title(); ?></h1>
                                                            <p><?php the_content(); ?></p>
                                                        </div>
                                                        
                                                        <!--==================================
                                                                    work goes here
                                                        =====================================-->
                                                        <?php get_work('custom_projects', 7, null, 0); ?>
                                                                                 
                                                        <!--<div id="contact">
                                                            <h1>Talk to us</h1>
                                                            <form method="post" action="form.php" id="form">
                                                                <input  type="text" name="name" value="Name" id="name" />
                                                                <input  type="tel" name="phone" value="Phone Number" id="phone" />
                                                                <input  type="email" name="email" value="Email" id="email" />
                                                                
                                                                <textarea id="message" name="message">Message</textarea>
                                                                
                                                                <input id="submit" type="button" name="submit" value="Submit" />
                                                            </form>
                                                        </div>-->
                                                    </div><!--#feature-holder end-->
                                                
						    <footer class="article-footer">
                                                        <p class="clearfix"><?php the_tags('<span class="tags">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?></p>
						    </footer> <!-- end article footer -->
						    
						    <?php// comments_template(); ?>
					
					    </article> <!-- end article -->
					
					    <?php endwhile; ?>	
					
					    <?php else : ?>
					
        					<article id="post-not-found" class="hentry clearfix">
        					    <header class="article-header">
        						    <h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
        						</header>
        					    <section class="entry-content">
        						    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
        						</section>
        						<footer class="article-footer">
        						    <p><?php _e("This is the error message in the page-custom.php template.", "bonestheme"); ?></p>
        						</footer>
        					</article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <?php// get_sidebar(); ?>
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->
                        


<?php get_footer(); ?>
