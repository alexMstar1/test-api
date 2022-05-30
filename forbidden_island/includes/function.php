<?php

function generator($resident_id)
{
    global $wpdb, $table_prefix;
    $total = rand(3, 20);

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "items"));

    $filter = filterItem($total, $result);
    while ($total !=0){
        $random_item = rand(0, count($filter) -1);
        $random_item = $filter[''];

        $result = $wpdb->insert($table_prefix . "items", array(
            'resident_id'=> $resident_id,
            'item_id'=>$random_item->id,
        ));
        $total = $total - $random_item->value;
        $filter = filterItem($total, $filter);

    }
   }
   function filter($total, $items){
    $filter = [];
    foreach ($items as $item){
        if ($item->value <=$total){
            $filter[] = $item;
        }
    }
    return $filter;
   }
function checkResident($resident_id)
{
    global $wpdb, $table_prefix;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "residents WHERE id = " . $resident_id . " ORDER BY id "));
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function checkItems($resident_id, $items)
{
    global $wpdb, $table_prefix;

    $items_DB = $wpdb->get_results($wpdb->prepare("SELECT " . $table_prefix . "items.name FROM 
   `" . $table_prefix . "residents` INNER JOIN " . $table_prefix . "items ON " . $table_prefix . "items.resident_id = 
   " . $table_prefix . "residents.id INNER JOIN " . $table_prefix . "items ON " . $table_prefix . "items.id = 
   " . $table_prefix . "items.item_id WHERE " . $table_prefix . "resident_id = " . $user_id));

    $items_DB = itemsArray($items_DB);
    $diff_array = array_diff($items->items, $items_DB);

    if (!empty($diff_array)) {
        return false;
    } else {
        if (checkAll($items)) {
            return true;
        } else {
            return false;
        }
    }
}
function itemsArray($array_object_items)
{
    $array = [];
    foreach ($array_object_items as $item) {
        $array[] = $item->name;
    }
    return $array;
}
function checkAll($items)
{
    global $wpdb, $table_prefix;

    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $table_prefix . "items"));

    if ($items->total) {
        $total_count = 0;
        foreach ($items->items as $item) {
            foreach ($result as $results) {
                if ($item === $result->name) {
                    $total_count = $total_count + $result->value;
                }
            }
        }
        if ($items->total === $total_count) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function result($result, $code = 200, $items = null)
{
    if (!$items) {
        return array(
            'code' => $code,
            'result' => $result
        );
    } else {
        return array(
            'code' => $code,
            'result' => $result,
            'items' => $items
        );
    }
}