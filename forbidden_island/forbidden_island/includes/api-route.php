<?php
if (!defined('ABSPATH')) {
    exit;
}
function select_residents()
{
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT*FROM" . $table_prefix . "residents"));

    return ($result);
}

function add_resident(WP_REST_Request $request)
{

    $resident_names = (string)$request['name'];

    global $wpdb, $table_prefix;
    $result = $wpdb->insert($table_prefix . "residents", array(
        'name' => $resident_names,

    ));
    $last_inserted_id = $wpdb->insert_id;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "residents WHERE id = " . $last_inserted_id . "ORDER BY id"));

    return ($result);

}

function remove_resident(WP_REST_Request $request)
{
    $resident_id = (int)$request['id'];
    global $wpdb, $table_prefix;
    $result = $wpdb->delete($table_prefix . 'residents', array(
        'id' => $resident_id,
    ));
    result('REMOVED');

}

function edit_resident(WP_REST_Request $request)
{
    $resident_id = (int)$request['id'];
    $resident_name = (string)$request['name'];

    global $wpdb, $table_prefix;
    $result = $wpdb->update($table_prefix . "residents", array(
        'name' => $resident_name
    ), array(
        'id' => $resident_id
    ));
    $result = $wpdb->get_results($wpdb->prepare("SELECT*FROM" . $table_prefix . "resident WHERE id =" . $resident_id . "ORDER BY id"));
    return ($result);

}

function get_resident(WP_REST_Request $request){
    $resident_id = (int)$request['id'];
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT*FROM". $table_prefix. "residents WHERE id = " . $resident_id));
    $items = $wpdb->get_results($wpdb->prepare("SELECT". $table_prefix . "items.name,".$table_prefix."items.value FROM" .$table_prefix ."residents INNER JOIN" .$table_prefix . "resident_items ON =".$table_prefix."residents.items.id_resident=".$table_prefix."residents.id INNER JOIN".$table_prefix . "resident_items ON" .$table_prefix."resident_items.id=" . $table_prefix ."resident_items.id_item WHERE". $table_prefix. "residents.id=" .$resident_id  ));
return result($result, $items);
}
function add_item(WP_REST_Request $request)
{
    $items_name = (string)$request['name'];
    $items_value = (int)$request['value'];

    global $wpdb, $table_prefix;
    $wpdb->insert($table_prefix . "items", array(
        'name' => $items_name,
        'value' => $items_value,
    ));

    $last_inserted_id = $wpdb->insert_id;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "items WHERE id = " . $last_inserted_id . " ORDER BY id "));

    return $result;
}
function get_item(WP_REST_Request $request)
{
    $item_id = (int)$request['id'];
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "items
        WHERE id = " . $item_id));

    return $result;
}
function remove_item(WP_REST_Request $request)
{
    $item_id = (int)$request['id'];

    global $wpdb, $table_prefix;
    $wpdb->delete($table_prefix . "island_items", array(
        'id' => $item_id,
    ));

    return ('DELETED');
}
function auction(WP_REST_Request $request)
{
    global $wpdb, $table_prefix;
    $seller_id = (int)$request['seller_id'];
    $customer_id = (int)$request['customer_id'];
    $seller_items = (string)$request['seller_items'];
    $customer_items = (string)$request['customer_items'];

    if ($seller_id === $customer_id || $seller_id === 0) {
        return result("Check consumer and creator", 422);
    }

    if (!checkResident($seller_id)) {
        return result("Resident " . $seller_id . " not found", 422);
    }
    if ($customer_id != 0) {
        if (!checkResident($customer_id)) {
            return result("Resident " . $customer_id . " not found", 422);
        }
    }

    $seller_items = json_decode($seller_items);
    $customer_items = json_decode($customer_items);

    if (!checkItems($seller_id, $seller_items)) {
        return result("Seller item not found", 422);
    }

    if ($customer_id != 0) {
        if (!checkItems($customer_items, $customer_id)) {
            return result("Customer item not found", 422);
        }
    } else {
        if (!checkTotal($customer_id)) {
            return result("Customer item not found", 422);
        }
    }

    if ($seller_items->total < $customer_items->total) {
        return result("not enough api", 422);
    }

    $result = $wpdb->insert($table_prefix . "auction", array(
        'seller_id' => $seller_items,
        'seller_id' => $customer_id,
        'status' => 'open',
        'customer_items' => json_encode($seller_items),
        'customer_items' => json_encode($customer_items),
    ));

    $last_inserted_id = $wpdb->insert_id;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction WHERE id = " . $last_inserted_id . " ORDER BY id "));

    return result($result);
}
function get_auction_items()
{
    global $wpdb, $table_prefix;
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction
        WHERE customer_id = 0"));

    return result($result);
}

function get_my_items(WP_REST_Request $request)
{
    $items_id = (int)$request['id'];
    global $wpdb, $table_prefix;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction
        WHERE seller_id =" . $items_id));

    return result($result);
}
function get_customer_items(WP_REST_Request $request)
{
    $item_id= (int)$request['id'];
    global $wpdb, $table_prefix;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction
        WHERE customer_id =" . $item_id));

    return result($result);
}
function open_auction_bid(WP_REST_Request $request)
{
    global $wpdb, $table_prefix;
    $bid_id = (int)$request['bid_id'];
    $customer_id = (int)$request['customer_id'];

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction
        WHERE id =" . $bid_id . " and consumer_id = 0 and status = 'open'"));

    if (!$result) {
        return result("bids not available", 422);
    }
    $bid = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction WHERE id = " . $bid_id . " ORDER BY id "));

    $customer_items = json_decode($bid[0]->customer_items);
    $seller_id = $bid[0]->seller_id;
    $seller_items = json_decode($bid[0]->seller_items);

    return result($result, $customer_id, $customer_items, $seller_id, $seller_items, $wpdb, $table_prefix, $bid);
}
function closed_auction_bid(WP_REST_Request $request)
{
    global $wpdb, $table_prefix;
    $bid_id = (int)$request['bid_id'];

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "auction
        WHERE id =" . $bid_id . " and status ='open'"));

    $bid = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "island_lots WHERE id = " . $bid_id . " ORDER BY id "));

    $customer_items = json_decode($bid[0]->customer_items);
    $seller_id = $bid[0]->seller_id;
    $seller_items = json_decode($bid[0]->seller_items);
    $customer_id = $bid[0]->customer_id;

    return result($result, $customer_id, $customer_items, $seller_id, $seller_items, $wpdb, $table_prefix, $bid_id);
}
function result($result, $customer_id, $customer_items, $seller_id, $seller_items, wpdb $wpdb, $table_prefix, $bid_id)
{
    if (!empty($result)) {
        if (!checkResident($customer_id) || !check($customer_id, $customer_items)) {
            return result("items not found", 422);
        }

        if (!checkResident($seller_id) || !check($seller_id, $seller_items)) {
            return result("items not found", 422);
        }
    }

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "items"));

    $customer_items = [];
    $customer_items_id = [];

    foreach ($customer_items->items as $customer_item) {
        foreach ($result as $results) {
            if ($customer_item === $results->name) {
                $consumer_items_id[] = $results->id;
            }
        }
    }

    foreach ($customer_items_id as $customer_items) {
        $wpdb->get_results($wpdb->prepare("UPDATE `" . $table_prefix . "items` SET resident_id = " . $customer_id . " WHERE item_id = " . $customer_item . " and  = " . $customer_id . " LIMIT 1"));
    }

    foreach ($seller_items->items as $seller_items) {
        foreach ($result as $results) {
            if ($customer_item === $results->name) {
                $customer_id[] = $results->id;
            }
        }
    }

    foreach ($seller_id as $seller_item) {
        $result = $wpdb->get_results($wpdb->prepare("UPDATE `" . $table_prefix . "items` SET resident_id = " . $customer_id . " WHERE item_id = " . $seller_item . " and resident_id = " . $seller_id . " LIMIT 1"));
    }

    $wpdb->update($table_prefix . "auction", array(
        'status' => 'done',
        'customer_id' => $customer_id
    ), array(
        'id' => $bid_id
    ));

    return result("bid complete");
}