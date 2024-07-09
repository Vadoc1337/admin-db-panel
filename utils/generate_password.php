<?php
$password = 'admin1337'; // Replace it with the desired password
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash of your password " . $hash;

# hash = $2y$10$q5S0CR1FqykxvCNBn3M1p.Bn5Mptf2ULnUR62mTJVo4f5pdyostgG