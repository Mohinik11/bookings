<?php
return [
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 465,
    'from' => array('address' => 'mohinikamboj11@gmail.com', 'name' => 'Mohini Kamboj'),
    'encryption' => 'ssl',
    'username' => '{username/email}',
    'password' => '{password}',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
];