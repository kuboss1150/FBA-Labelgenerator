<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['roles'] = [
    'home/index' => ['groups' => '*', 'title' => 'home', 'menu' => false],
    'auth/login' => ['groups' => '*', 'title' => 'Login', 'menu' => false],
    'auth/logout' => ['groups' => '*', 'title' => 'Logout', 'menu' => false],
    'auth/index' => ['groups' => 'admin', 'title' => 'ユーザー管理', 'menu' => true, 'url' => site_url('auth/index'), 'icon' => 'fa fa-user'],
    'auth/index_data' => ['groups' => 'admin', 'title' => 'Auth Data', 'menu' => false],
    'auth/create_user' => ['groups' => '*', 'title' => 'Create User', 'menu' => false],
    'auth/forgot_password' => ['groups' => '*', 'title' => 'Forgot Password', 'menu' => false],
    'auth/edit_user' => ['groups' => '*', 'title' => 'Edit User', 'menu' => false],
    'auth/activate' => ['groups' => '*', 'title' => 'Activate User', 'menu' => false],
    'auth/deactivate' => ['groups' => '*', 'title' => 'Deactivate User', 'menu' => false],
    
    'account/index' => ['groups' => 'members', 'title' => 'アカウント管理', 'menu' => true, 'url' => site_url('account/index'), 'icon' => 'fa fa-users'],
    'account/index_data' => ['groups' => 'members', 'title' => 'プロキシ管理一覧', 'menu' => false],
    'account/create' => ['groups' => 'members', 'title' => 'アカウント登録', 'menu' => false, 'menu_select'=>'account/index'],
    'account/edit' => ['groups' => 'members', 'title' => 'プロキシ管理', 'menu' => false],
    'account/set_account' => ['groups' => 'members', 'title' => 'Seller id select', 'menu' => false],
    
    'product/index' => ['groups' => 'members', 'title' => '商品マスター', 'menu' => true, 'url' => site_url('product/index'), 'icon' => 'fa fa-bars'],
    'product/index_data' => ['groups' => 'members', 'title' => '商品マスター', 'menu' => false],
    'product/create' => ['groups' => 'members', 'title' => 'Product create', 'menu' => false, 'menu_select'=>'product/index'],
    'product/edit' => ['groups' => 'members', 'title' => 'Product edit', 'menu' => false],
    'product/import' => ['groups' => 'members', 'title' => 'Product import', 'menu' => false],
    'product/export' => ['groups' => 'members', 'title' => 'Product export', 'menu' => false],
    
    'store/index' => ['groups' => 'members', 'title' => '入庫', 'menu' => true, 'url' => site_url('store/index'), 'icon' => 'fa fa-qrcode'],
    'store/get_product' => ['groups' => 'members', 'title' => '入庫', 'menu' => false],
    'store/generate' => ['groups' => 'members', 'title' => '入庫', 'menu' => false],
    'store/shipments' => ['groups' => 'members', 'title' => '出庫', 'menu' => true, 'url' => site_url('store/shipments'), 'icon' => 'fa fa-shopping-cart'],
    'store/add_shipment' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/shipment_name_update' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/get_shipment' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/get_sku' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/save_box' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/get_boxs' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/get_box_items' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/export_tsv' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    'store/export_csv' => ['groups' => 'members', 'title' => '出庫', 'menu' => false],
    
    'auth/change_password' => ['groups' => '*', 'title' => 'パスワードの変更', 'menu' => true, 'url' => site_url('auth/change_password'), 'icon' => 'fa fa-lock'],
];