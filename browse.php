<?php
/*
Template Name: Gaol Search/Browse Page
*/
//Font awesome
wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );
			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

		<?php //Tab layout from https://codepen.io/oknoblich/pen/tfjFl?editors=1100 ?>
        <!--GAOL SEARCH/BROWSE SECTION-->
        <div id="gaol-search">

            <input id="tab-find-person" class="gaol-search-tab" type="radio" name="tabs" checked>
            <label for="tab-find-person" class="gaol-search-tab-label">Find a person</label>

            <input id="tab-find-by-keyword" class="gaol-search-tab" type="radio" name="tabs">
            <label for="tab-find-by-keyword" class="gaol-search-tab-label">Search by keyword</label>

            <section id="find-person" class="gaol-search-section">
                <form role="search" method="get" class="search-form" action="<?php echo home_url( '/browse' ); ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <!--first name-->
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="Marry">
                        </div>
                        <!--last name-->
                        <div class="form-group col-md-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Ann">
                        </div>
                    </div>
                    <div class="form-row">
                        <!--country-->
                        <div class="form-group col-md-8">
                            <label for="countryOfBirth">Country of birth</label>
                            <input type="text" class="form-control" id="countryOfBirth" placeholder="England">
                        </div>
                        <!--trade-->
                        <div class="form-group col-md-4">
                            <label for="trade">Trade</label>
                            <select id="trade" class="form-control" name="trade">
                                <option disabled selected value="">Select...</option>
	                            <?php
                                    foreach (get_all_meta_values('bio_trade', true) as $trade){
                                        echo "<option value='$trade'>$trade</option>";
                                    }
	                            ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="post_type" value="convict" />
                    <input type="hidden" name="s" value="test" />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </section>

            <section id="find-by-keyword" class="gaol-search-section">
                <p>
                    Bacon ipsum dolor sit amet landjaeger sausage brisket, jerky drumstick fatback boudin ball tip
                    turducken. Pork belly meatball t-bone bresaola tail filet mignon kevin turkey ribeye shank flank
                    doner cow kielbasa shankle. Pig swine chicken hamburger, tenderloin turkey rump ball tip sirloin
                    frankfurter meatloaf boudin brisket ham hock. Hamburger venison brisket tri-tip andouille pork
                    belly ball tip short ribs biltong meatball chuck. Pork chop ribeye tail short ribs, beef
                    hamburger meatball kielbasa rump corned beef porchetta landjaeger flank. Doner rump frankfurter
                    meatball meatloaf, cow kevin pork pork loin venison fatback spare ribs salami beef ribs.
                </p>
                <p>
                    Jerky jowl pork chop tongue, kielbasa shank venison. Capicola shank pig ribeye leberkas filet
                    mignon brisket beef kevin tenderloin porchetta. Capicola fatback venison shank kielbasa,
                    drumstick ribeye landjaeger beef kevin tail meatball pastrami prosciutto pancetta. Tail kevin
                    spare ribs ground round ham ham hock brisket shoulder. Corned beef tri-tip leberkas flank
                    sausage ham hock filet mignon beef ribs pancetta turkey.
                </p>
            </section>
        </div>

        <hr>
        <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
            <label>
                <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
                <input type="hidden" name="post_type" value="convict" />
            </label>
            <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
        </form>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
