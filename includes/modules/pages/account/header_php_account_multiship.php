<?php
// ---------------------------------------------------------------------------
// Part of the Multiple Shipping Addresses plugin for Zen Cart v1.5.5 and later
//
// Copyright (C) 2014-2017, Vinos de Frutas Tropicales (lat9)
//
// @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
// ---------------------------------------------------------------------------
//
if (count($ordersArray) > 0) {
    foreach ($ordersArray as &$currentOrder) {
        $check = $db->Execute(
            "SELECT om.delivery_country AS country, o.order_total FROM " . TABLE_ORDERS_MULTISHIP . " om
                INNER JOIN " . TABLE_ORDERS . " o
                    ON o.orders_id = om.orders_id
              WHERE om.orders_id = " . $currentOrder['orders_id']
        );
        if (!$check->EOF) {
            $country = $check->fields['country'];
            while (!$check->EOF) {
                if ($country != $check->fields['country']) {
                    $country = MULTISHIP_MULTIPLE;
                }
                $check->MoveNext();
            }
            $currentOrder['order_name'] = MULTISHIP_MULTIPLE_ADDRESSES;
            $currentOrder['order_country'] = $country;
            $currentOrder['order_total'] = $check->fields['order_total'];
        }
    }
}