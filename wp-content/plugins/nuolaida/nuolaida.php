<?php
/**
 * Plugin Name: Lojalus Pirkėjas
 * Description: Suteikia 10% nuolaidą lojaliems klientams po pirmojo pirkimo
 * Version: 1.0.0
 */

// Užkirsti kelią tiesioginiam pasiekimui
if (!defined('ABSPATH')) {
    exit;
}

/**
 * HOOK 1: Po sėkmingo apmokėjimo - suteikti statusą
 * 
 * WooCommerce hook'as: 'woocommerce_payment_complete'
 * Iškviečiamas kai apmokėjimas sėkmingai baigtas
 */
add_action('woocommerce_payment_complete', 'loyal_customer_grant_status', 10, 1);

function loyal_customer_grant_status($order_id) {
    // Gauti užsakymo objektą
    $order = wc_get_order($order_id);
    
    // Gauti vartotojo ID
    $user_id = $order->get_user_id();
    
    // Jei vartotojas neprisijungęs (svečias) - nieko nedaryti
    if (!$user_id) {
        return;
    }
    
    // Patikrinti ar vartotojas jau turi statusą
    $has_status = get_user_meta($user_id, '_loyal_customer', true);
    
    // Jei dar neturi - suteikti
    if (!$has_status) {
        update_user_meta($user_id, '_loyal_customer', 'active');
        update_user_meta($user_id, '_loyal_customer_since', current_time('mysql'));
        
        // Pridėti pastabą prie užsakymo
        $order->add_order_note('Vartotojui suteiktas lojalaus pirkėjo statusas!');
        
        // Debug (jei įjungtas)
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("Lojalus pirkėjas: Statusas suteiktas vartotojui #{$user_id}");
        }
    }
}

/**
 * HOOK 2: Pritaikyti 10% nuolaidą lojaliems klientams
 * 
 * WooCommerce hook'as: 'woocommerce_before_calculate_totals'
 * Iškviečiamas prieš skaičiuojant krepšelio sumas
 */
add_action('woocommerce_before_calculate_totals', 'loyal_customer_apply_discount', 10, 1);

function loyal_customer_apply_discount($cart) {
    // Apsauga nuo begalinių ciklų
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    
    // Patikrinti ar vartotojas prisijungęs
    if (!is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    
    // Patikrinti ar vartotojas turi lojalaus pirkėjo statusą
    $is_loyal = get_user_meta($user_id, '_loyal_customer', true);
    
    if ($is_loyal !== 'active') {
        return;
    }
    
    // Pritaikyti 10% nuolaidą kiekvienai prekei
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $original_price = floatval($product->get_price());
        $discounted_price = $original_price * 0.9; // 10% nuolaida
        
        $product->set_price($discounted_price);
    }
    
    // Pridėti pranešimą krepšelyje
    WC()->session->set('loyal_discount_applied', true);
}

/**
 * HOOK 3: Pridėti pranešimą krepšelyje apie nuolaidą
 */
add_filter('woocommerce_cart_totals_before_order_total', 'loyal_customer_show_discount_message');

function loyal_customer_show_discount_message() {
    if (!is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    $is_loyal = get_user_meta($user_id, '_loyal_customer', true);
    
    if ($is_loyal === 'active' && WC()->session->get('loyal_discount_applied')) {
        echo '<tr class="loyal-discount-info">';
        echo '<th colspan="2" style="color: green; padding: 10px; background: #f0fff0;">';
        echo '🎉 Jums pritaikyta 10% lojalumo nuolaida!';
        echo '</th>';
        echo '</tr>';
    }
}

/**
 * HOOK 4: Rodyti vartotojo statusą paskyros puslapyje
 * 
 * WooCommerce hook'as: 'woocommerce_account_content'
 * Rodo turinį paskyros puslapyje
 */
add_action('woocommerce_account_content', 'loyal_customer_show_status_in_account');

function loyal_customer_show_status_in_account() {
    if (!is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    $is_loyal = get_user_meta($user_id, '_loyal_customer', true);
    $since = get_user_meta($user_id, '_loyal_customer_since', true);
    
    if ($is_loyal === 'active') {
        $date = $since ? date('Y-m-d', strtotime($since)) : 'neseniai';
        
        echo '<div style="background: #e8f5e8; padding: 20px; margin: 20px 0; border-left: 4px solid #4CAF50; border-radius: 4px;">';
        echo '<h3>🌟 Jūsų lojalumo statusas</h3>';
        echo '<p><strong>Lojalus pirkėjas</strong> nuo ' . $date . '</p>';
        echo '<p>🎁 Jums taikoma 10% nuolaida visoms prekėms!</p>';
        echo '</div>';
    } else {
        echo '<div style="background: #f9f9f9; padding: 20px; margin: 20px 0; border-left: 4px solid #999; border-radius: 4px;">';
        echo '<h3>🎯 Tapkite lojaliu pirkėju</h3>';
        echo '<p>Užbaikite pirmąjį pirkimą ir gaukite 10% nuolaidą visoms būsimoms prekėms!</p>';
        echo '</div>';
    }
}

/**
 * HOOK 5: Administratoriaus skiltis - matyti lojalius klientus
 */
add_action('show_user_profile', 'loyal_customer_admin_field');
add_action('edit_user_profile', 'loyal_customer_admin_field');

function loyal_customer_admin_field($user) {
    $is_loyal = get_user_meta($user->ID, '_loyal_customer', true);
    $since = get_user_meta($user->ID, '_loyal_customer_since', true);
    ?>
    <h3>Lojalaus pirkėjo informacija</h3>
    <table class="form-table">
        <tr>
            <th><label>Lojalus pirkėjas</label></th>
            <td>
                <label>
                    <input type="checkbox" name="loyal_customer" value="1" <?php checked($is_loyal, 'active'); ?>>
                    Šis vartotojas yra lojalus pirkėjas
                </label>
                <?php if ($since): ?>
                <p class="description">Nuo: <?php echo $since; ?></p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php
}

// Išsaugoti admin nustatymus
add_action('personal_options_update', 'loyal_customer_save_admin_field');
add_action('edit_user_profile_update', 'loyal_customer_save_admin_field');

function loyal_customer_save_admin_field($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    if (isset($_POST['loyal_customer'])) {
        update_user_meta($user_id, '_loyal_customer', 'active');
        if (!get_user_meta($user_id, '_loyal_customer_since', true)) {
            update_user_meta($user_id, '_loyal_customer_since', current_time('mysql'));
        }
    } else {
        delete_user_meta($user_id, '_loyal_customer');
    }
}
