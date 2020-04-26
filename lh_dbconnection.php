<?php

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE {$wpdb->base_prefix}order_system (
    order_key int(10) NOT NULL AUTO_INCREMENT,
    name varchar(255) not null,
    email varchar(255) not null,
    phone int(9) not null,
    what text not null,
    created_at datetime NOT NULL,
    is_done boolean default 0 NOT NULL,
    PRIMARY KEY (order_key)
) $charset_collate;";

require_once(ABSPATH . "wp-admin/includes/upgrade.php");
dbDelta($sql);