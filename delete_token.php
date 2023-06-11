<?php

use App\Model\DB;

$sql = "DELETE FROM users WHERE token IS NOT NULL and role_id = 6 AND registration_date_time <= NOW() - INTERVAL 1 DAY";
$stmt = DB::getInstance()->prepare($sql);
$stmt->execute();

$sql = "UPDATE users SET token = NULL WHERE token IS NOT NULL AND role_id != 6";
$stmt = DB::getInstance()->prepare($sql);
$stmt->execute();