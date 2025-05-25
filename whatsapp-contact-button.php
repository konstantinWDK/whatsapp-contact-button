<?php
/*
Plugin Name: WhatsApp Contact Floating Button
Description: Muestra un botón flotante de WhatsApp con tooltip animado. Personalizable desde el panel de administración.
Version: 1.0
Author: Konstantin WDK
*/

// Bloquear acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Registrar opciones del plugin
function wcfb_register_settings() {
    add_option( 'wcfb_whatsapp_number', '34600000000' );
    add_option( 'wcfb_tooltip_title', '¿Tienes dudas?' );
    add_option( 'wcfb_tooltip_text', 'Nosotros te ayudamos' );
    add_option( 'wcfb_popup_delay', '15000' );

    register_setting( 'wcfb_options_group', 'wcfb_whatsapp_number' );
    register_setting( 'wcfb_options_group', 'wcfb_tooltip_title' );
    register_setting( 'wcfb_options_group', 'wcfb_tooltip_text' );
    register_setting( 'wcfb_options_group', 'wcfb_popup_delay' );
}
add_action( 'admin_init', 'wcfb_register_settings' );

// Crear menú en el admin
function wcfb_register_options_page() {
    add_options_page('WhatsApp Button Settings', 'WhatsApp Button', 'manage_options', 'wcfb', 'wcfb_options_page');
}
add_action('admin_menu', 'wcfb_register_options_page');

function wcfb_options_page() {
?>
    <div class="wrap">
        <h1>Configuración del Botón de WhatsApp</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wcfb_options_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Número de WhatsApp</th>
                    <td><input type="text" name="wcfb_whatsapp_number" value="<?php echo esc_attr( get_option('wcfb_whatsapp_number') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Título del mensaje</th>
                    <td><input type="text" name="wcfb_tooltip_title" value="<?php echo esc_attr( get_option('wcfb_tooltip_title') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Texto del mensaje</th>
                    <td><input type="text" name="wcfb_tooltip_text" value="<?php echo esc_attr( get_option('wcfb_tooltip_text') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Tiempo antes de mostrar el mensaje (ms)</th>
                    <td><input type="number" name="wcfb_popup_delay" value="<?php echo esc_attr( get_option('wcfb_popup_delay') ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Cargar assets
function wcfb_enqueue_assets() {
    wp_enqueue_style( 'wcfb-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
    wp_enqueue_script( 'wcfb-script', plugin_dir_url( __FILE__ ) . 'js/script.js', array(), false, true );
    wp_localize_script( 'wcfb-script', 'wcfb_data', array(
        'number' => get_option('wcfb_whatsapp_number'),
        'title'  => get_option('wcfb_tooltip_title'),
        'text'   => get_option('wcfb_tooltip_text'),
        'delay'  => intval( get_option('wcfb_popup_delay') )
    ) );
}
add_action( 'wp_enqueue_scripts', 'wcfb_enqueue_assets' );

// Insertar HTML en el footer
add_action('wp_footer', 'wcfb_insert_button');
function wcfb_insert_button() {
    ?>
    <div class="whatsapp-button-container">
        <div class="whatsapp-float" id="whatsappBtn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        </div>
        <div class="whatsapp-tooltip" id="whatsappTooltip">
            <button class="whatsapp-close" id="closeTooltip" aria-label="Cerrar mensaje">&times;</button>
            <h4 id="tooltip-title"></h4>
            <p id="tooltip-text"></p>
            <div class="contact-wrapper">
                <button class="whatsapp-contact-small" id="whatsappContactBtn">Contactar</button>
            </div>
        </div>
    </div>
    <?php
}
