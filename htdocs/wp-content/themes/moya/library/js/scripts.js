// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        }
        return this;
    }
}


// Kyles functions -----------------------------------------------

// corrects the position of the preloader on reponsive image sizes on each project preview
// also sets preloaders to their initial state of not being visible, this helps when we need to reset them later
function position_preloaders(){
    jQuery('.dim').each(function(){
        jQuery(this).css('background', 'rgba(0,0,0,0)');
        jQuery(this).children('.loader').addClass('hidden');
        
        $this_preview_image = jQuery(this).children('.preview_img');

        jQuery(this).children('.loader').css({
            left: $this_preview_image.width()/2 - 5,
            top: $this_preview_image.height()/2
        });
    });
}

// initiate isotope
function isotope_init(){
    is_isotope = true;
    
    jQuery('#feature-holder').imagesLoaded(function() {
        jQuery(this).isotope({
            itemSelector: '.isotope-me',
            animationEngine : 'jquery',
            masonry : {
                columnWidth : 5
            }
        });
    });
}   

// get rid of isotope
function isotope_destroy(){
    is_isotope = false;
    
    jQuery('#feature-holder').isotope('destroy');
}

// remove Wordpress width, height, and style attributes from these elements
// our responsive layout is not happy with these attributes, get rid of them!
// also centers the preloader images ontop of each project preview div <- not yet *******************
function responsive_imgs_pls(){
    jQuery('.the_project img, .wp-caption').removeAttr('width height style');    
}

function compute_viewport(){
    windowOffset = jQuery(window).scrollTop();
    windowHeight = jQuery(window).height();
    docHeight = jQuery(document).height() - 1; //this -1 pixel makes me feel like a "safe zone", in reality it probably does nothing
    
    sweetSpot = windowOffset + windowHeight;
}

// ajax scroll load function
function scroll_load(){
    compute_viewport();

    if(sweetSpot >= docHeight){
        //display loader so end user knows something is going on
        jQuery('#loading-div').removeClass('hidden');
        jQuery(window).unbind('scroll');
        
        //go fetch the posts
        jQuery.ajax({
            url: php_data.template_directory + '/library/includes/grab_posts.php',
            type: 'POST',
            //get the amount of project currently loaded (offset) for the get_posts in the ajax call
            //-1 because the welcome div is always there, doesnt count as a project
            data: { offset : (jQuery('#feature-holder').children().size() - 1) },
            success: function(result){
                if(result !== 'error1'){
                   $newElements = jQuery(result);

                   // make sure images are preloaded on new elements
                   // fixes for chrome being too fast trying to layout the elements before the images are even loaded
                   $newElements.imagesLoaded(function(){
                       //populate new posts differently if isotope is initiated or not
                       if(is_isotope){
                            jQuery('#feature-holder').isotope( 'insert', this, function(){
                                // make sure Wordpress' default inline styles are removed from recently added elements
                                responsive_imgs_pls();

                                //initiate the scrolling event again once isotope is finished doing its thing
                                jQuery(window).scroll(scroll_load);

                                //kill loader so things look pretty again
                                jQuery('#loading-div').addClass('hidden');
                            });
                       }else{
                           jQuery('#feature-holder').append($newElements);

                           //initiate the scrolling event again once the extra items have been added to the DOM
                           jQuery(window).scroll(scroll_load);

                           //kill loader so things look pretty again
                           jQuery('#loading-div').addClass('hidden');
                       }
                   });

                   
                }else{
                   // tell end user there is no more posts then kill loader nicely
                   // and never initiate the scroll event again
                   jQuery('#loading-div')
                        .html('<span style="color:white;">No more Projects.</span>')
                        .delay(2000)
                        .fadeOut('slow', function(){ jQuery('#loading-div').addClass('hidden'); })
                   ;
                }
            },
            error: function(){
                alert('Error loading projects.');
            }
        });
    }
} // scroll_load()

function project_load(){
    // kill the scroll event so scrolling which occurs form resizing doesnt happen
    jQuery(window).unbind('scroll');
    
    // selector of the project div based on which .dim was clicked
    // the scope of jQuery(this) changes within the ajax so we set it now
    $this_project = jQuery(this).parent();
    
    // removes the clicking of this or any other project until the loading is complete
    jQuery('.dim').die('click');

    // position the preloaders if it hasn't been done already
    position_preloaders();
    jQuery(this).css('background', 'rgba(0,0,0,0.7)');
    jQuery(this).children('.loader').removeClass('hidden');

    jQuery.ajax({
        url: php_data.template_directory + '/library/includes/grab_project.php',
        type: 'POST',
        data: { project_id : jQuery(this).parent().data('id') }, //the id of the full project to load
        success: function(result){
            $newElements = jQuery(result);
            
            // make sure images are preloaded on new elements before calling isotope (or doing anything really) **** double check this for scroll_load function ****
            // fix for chrome being too fast trying to layout the elements before the images are even loaded
            $newElements.imagesLoaded(function(){
                // remove projects that have already been requested
                jQuery('.the_project').remove();
                
                // any previews that was hidden must be reset and shown again, including their preloaders
                jQuery('.preview').not($this_project).removeClass('hidden');
                position_preloaders();
                
                // hide the project that was just clicked
                $this_project.addClass('hidden');
                
                // throw in the new html which was retrieved from the ajax
                $this_project.after($newElements);
                
                // make sure Wordpress' default inline styles are removed from recently added elements
                responsive_imgs_pls();
                
                // relayout isotope/page
                if(is_isotope){
                    jQuery('#feature-holder').isotope( 'reLayout', function(){
                        // let there be scrolling once again
                        jQuery(window).scroll(scroll_load);

                        // let there be clicking of projects once again too
                        jQuery('.dim').live('click', project_load);
                    });
                }else{ //fallback for when isotopes it not initiated, we still need to bind the click event to the previews again
                    // let there be scrolling once again
                    jQuery(window).scroll(scroll_load);
                    
                    jQuery('.dim').live('click', project_load);
                }
            });
            
        },
        error: function(){
            alert('Error loading projects.');
        }
    });
    
    // remove and add all videos to the DOM so they all stop playing when selecting another project
    /*jQuery('.the_project .flex-video').each(function(){
        jQuery(this).html(jQuery(this).html());
    });*/

    // HIDE ALL PROJECTS/SHOW ALL PREVIEWS
    /*jQuery('.the_project').addClass('hidden');
    jQuery('.preview').removeClass('hidden');*/

    // HIDE PREVIEW/SHOW PROJECT
    /*jQuery(this).parent().addClass('hidden');
    jQuery(this).parent().next('.the_project').removeClass('hidden');*/

} // project_load()



// as the page loads, call these scripts -------------------------
jQuery(document).ready(function($) {
    /*
    Responsive jQuery is a tricky thing.
    There's a bunch of different ways to handle
    it, so be sure to research and find the one
    that works for you best.
    */
    
    /* getting viewport width */
    responsive_viewport = $(window).width();

    /* if is below 481px */
    if (responsive_viewport < 481) {
        
    } /* end smallest screen */
    
    /* if is larger than 481px */
    if (responsive_viewport > 481) {
        
    } /* end larger than 481px */
    
    /* if is above or equal to 768px */
    if (responsive_viewport >= 768) {
        // initiate isotope if we have nothing media queried
        isotope_init();  
    
        /* load gravatars */
        $('.comment img[data-gravatar]').each(function(){
            $(this).attr('src',$(this).attr('data-gravatar'));
        });
        
    }
    
    /* if is below or equal to 768px */
    if (responsive_viewport <= 768) {
        // tell the rest of the script isotope was not initiated because the browser loaded on a media query
        is_isotope = false;
    }
    
    /* off the bat large screen actions */
    if (responsive_viewport > 1030) {
        
    }
    
    // destroy isotopes at a certain viewport size so our responsive stuff is happy
    $(window).resize(function(){    
        responsive_viewport = $(window).width();
        position_preloaders();
        
        if (responsive_viewport <= 768 && is_isotope) {
            isotope_destroy();
        }
        else if (responsive_viewport >= 768 && !is_isotope){
            isotope_init();
        }
        
    });

    // open prjects view
    $('.dim').live('click', project_load);
        
    // clean up the content for responsive goodness
    responsive_imgs_pls();    
    
    // call ajax scroll_load function   
    //hold this stuff off until the window is loaded because the offset variable is reliant on the DOM being loaded and settled
    $(window).load(function(){
        $(window).scroll(scroll_load);
    });
    
        
        
 
}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
    var doc = w.document;
    if( !doc.querySelector ){ return; }
    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;
    if( !meta ){ return; }
    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true; }
    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false; }
    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
        if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );