<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Nz_Social_Contacts
 * @subpackage Nz_Social_Contacts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nz_Social_Contacts
 * @subpackage Nz_Social_Contacts/public
 * @author     Your Name <email@example.com>
 */
class Nz_Social_Contacts_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        if (get_option('include_css')) {

            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nz-social-contacts-public.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/nz-social-contacts-public.js', array('jquery'), $this->version, false);
    }

    public function add_shortcodes()
    {
        add_shortcode('nz-social-contacts', array($this, 'shortode_func'));
    }

    public function shortode_func()
    {
        $wrap = '<ul id="nz-socials">%s</ul>';
        $wrapper = '<li><a target="_blank" href="%s" class="%s">%s</a></li>';
        $icon = '<i class="%s"></i>';
        $detail = '<div>%s</div>';

        $options = json_decode(get_option('fields'), true);

        $content = '';
        if (!empty($options)) {
            foreach ($options as $social) {
                $i = sprintf($icon, $social['icon_class']);
                if (!empty($social['detail'])) {
                    $i.= sprintf($detail, $social['detail']);
                }
                $content .= sprintf($wrapper, $social['link'], $social['class'], $i);
            }
            $content = sprintf($wrap, $content);
        }
        return $content;
        //old layout

        $options = json_decode(get_option('fields'), true);

        if (!empty($options)) {
            ?>
            <div id="nz-socials">
                <?php
                foreach ($options as $social) {
                    ?>
                    <div class="social">
                        <a target="_blank" href="<?php echo $social['link'] ?>" class="<?php echo $social['class'] ?>">
                            <i class="<?php echo $social['icon_class'] ?>"></i>
                        </a>
                        <?php if (!empty($social['detail'])) { ?>
                            <div>
                                <p><?php echo $social['detail'] ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}
