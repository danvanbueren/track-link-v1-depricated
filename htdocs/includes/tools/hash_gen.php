<?php

/* Hash generation tool */
$password = "test";
$hash = password_hash($password, PASSWORD_DEFAULT);
$verifyagainst = "test";

$result = "failed";

if (password_verify($verifyagainst, $hash)) {$result = "passed";};

echo "<p><b>Source: </b>".$password."</br><b>&#8627 Hash: </b>".$hash."</br><b>Verify: </b>".$verifyagainst."</br><b>&#8627 Result: </b>".$result."</p>";