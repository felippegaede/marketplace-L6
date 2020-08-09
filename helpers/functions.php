<?php

function filterItemsByStoreId(array $items, $storeId)
{
    return array_filter($items, function($item) use($storeId){

        return $item['store_id'] == $storeId;

    });
}
