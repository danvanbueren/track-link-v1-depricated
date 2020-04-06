<?php

$var = $_POST['data'];
$hash = password_hash($var, PASSWORD_DEFAULT);

if($var != "") {
print_r("<code>".$hash."</code>");
} else {
echo '<span class="text-muted"><i>waiting for input...</i></span>';
}
?>