<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);



// ajax search
add_action( 'wp_footer', 'ajax_fetch' );

function ajax_fetch() {
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function fetch(){
            $.ajax({
                url: '<?= admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: { action: 'data_fetch', keyword: $('#home__keyword').val() },
                success: function(data) {
                    if($('#home__keyword').val().length > 0) {
                        $('.home__data').removeClass( 'hidden' );
                        $('.home__data').addClass( 'block' );
                        $('#home__dataFetch').html( data );
                    } else {
                        $('.home__data').removeClass( 'block' );
                        $('.home__data').addClass( 'hidden' );
                        $('#home__dataFetch').html('');
                    }
                }
            });
        }
    </script>
<?php
}


add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');

function data_fetch(){
    $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'post' ) );
    if ( $the_query->have_posts()) : 
    ?>
        <?php while( $the_query->have_posts() ): $the_query->the_post(); ?>
            <article class="relative w-full lg:w-1/3 px-6 mb-6 lg:mb-0">
                <div class="flex flex-wrap lg:flex-no-wrap lg:flex-col">
                    <a href="<?= get_the_permalink(); ?>" class="absolute top-0 left-0 w-full h-full"></a>
                    <img src="<?= the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="" class="w-full object-cover object-center h-64">
                    <header class="mt-2">
                        <h1 class="text-sm lg:mb-5"><?= get_the_title() ?></h1>
                    </header>
                </div>
            </article>
        <?php endwhile; ?> 
    <?php wp_reset_postdata();

    else : ?>
        <div class="text-center w-full pb-6 mt-8">
            <h4 class="mb-6 lg:mb-8">Sorry, no results for</h4>
            <p>
                "<?= esc_attr( $_POST['keyword'] ); ?>"
            </p>
            <a href="#" class="underline" id="home__try">Try a new search</a>
        </div>
        <script>
            $('#home__try').on('click', function (e) {
                e.preventDefault();
                $('#home__keyword').val('');
                $('#home__keyword').focus();
                $('.home__data').addClass('hidden');
            })
        </script>
    <?php

    endif;

    die();
}