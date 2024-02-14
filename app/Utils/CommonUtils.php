<?php

function paginate($foundEntities): stdClass
{
    $pagination = new stdClass();
    $pagination->currentPage = $foundEntities->currentPage();
    $pagination->perPage = $foundEntities->perPage();
    $pagination->lastPage = $foundEntities->lastPage();
    $pagination->total = $foundEntities->total();
    return $pagination;
}

function arrayToObject(array $array): object
{
    return json_decode(json_encode($array), false);
}
