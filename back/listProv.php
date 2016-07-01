<?php
include "config.php";

$where_condition = ' AND (';
if (sizeof($_GET) > 0) {
    $full_name = $_GET['nombres'];
    $email = $_GET['email'];
    if ($full_name) {
        $where_condition.= " full_name LIKE '%{$full_name}%' ";
    }

    if ($email) {
        $where_condition.= ( $where_condition === ' AND (' ? '' : ' OR ' ) . " email LIKE '%{$email}%' ";
    }
}
$where_condition.= ( $where_condition === ' AND (' ? '1)' : ')' ); 

$contacts = array();
$result = mysql_query("SELECT id, full_name, email, phone, address FROM proveedores WHERE 1 {$where_condition} ORDER BY id DESC");
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $contacts[]= array(
        'id' => $row['id'], 
        'full_name' => $row['nombres'], 
        'email' => $row['apellidos'], 
        'phone' => $row['cedula'], 
        'address' => $row['lugar']
    );
}
echo json_encode($contacts);
