<?php
$region_ids = $_POST['region_ids'];
$products = ['site_products'];

$site_products = [];
foreach ($products as $product) {
  $site_products[]["site_product"] = $product;
}

function get_id_task($region_ids, $site_products) {
  $headers = ['Authorization: Token fa78f26d09dfe997c5a5cd651b9452cac90c05e5'];
  $ch=curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://apimarket.parserdata.ru/task/create/');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

  $arr_post = [
    "region_ids" => $region_ids,
    "site_products" => $site_products
  ];

  if(count($arr_post) > 0) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr_post));
  }
  $data=curl_exec($ch);
  curl_close($ch);

  return $data;
}

function get_data($task_id) {
  $headers = ['Authorization: Token fa78f26d09dfe997c5a5cd651b9452cac90c05e5'];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://apimarket.parserdata.ru/task/' .$task_id. '/products/?page=1');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch, CURLOPT_HTTPGET, 1);

  $data = curl_exec($ch);
  curl_close($ch);

  $result = json_decode($data);
  $status = $result->{'status'};
  if ($status !== 'DONE') {
    sleep(3);
    return get_data($task_id);
  } else {
    return $data;
  }
}

$task_id_obj = json_decode(get_id_task($region_ids, $site_products));
$task_id = $task_id_obj->{'task_id'};
$result = json_decode(get_data($task_id));

print_r($result);