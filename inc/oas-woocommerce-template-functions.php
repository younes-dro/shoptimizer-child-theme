<?php

/**
 * 
 * 
 * 
 */
function oas_discount_price_cart( $product, $qty, $total = false ) {

    $original_price = $product->regular_price * $qty;

    // Call from total section 
    if ($total) {

        return $original_price;
    }

    return '<del>' . wc_price($original_price) . '</del>';
}

function oas_sale_price_total ( $product, $qty ) {
    $sale_price = $product->sale_price * $qty;
    
    return $sale_price;
    
}

function oas_discount_total (  ){
    $total_shipping = floatval(WC()->cart->get_shipping_total());
    $total_produts = 0;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $total_produts += oas_sale_price_total($_product, $cart_item['quantity'], true);
    }    
    
    return $total_shipping + $total_produts ;
}

function oas_original_total() {
    $total_shipping = floatval(WC()->cart->get_shipping_total());

    $total_produts = 0;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $total_produts += oas_discount_price_cart($_product, $cart_item['quantity'], true);
    }
    
    return  $total_produts + $total_shipping ;
    
}

function oas_saved_price() {

    $discount = wc_price ( oas_original_total() - oas_discount_total() );

   return $discount ;
}
