<?php


$file = file_get_contents("https://perfume-bd.com/product/armaf-club-de-nuit-intense-men-edt-105-ml-for-men/");



$dom = new DOMDocument;
@$dom->loadHTML($file);

/* $scrape = new DomXPath($dom);
$classname = "woocommerce-product-details__short-description";
$nodes = $scrape->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]"); */

$scrape = $dom->getElementsByTagName('h1');

foreach ($scrape as $data) {
    var_dump($data->nodeValue);
}