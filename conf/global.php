<?php

define('DATABASE', 'mysql:host=localhost;port=3308;dbname=todonew;charset=utf8');
define('LOGIN', 'root');
define('PASSWD', "");
define('SALT', 'zcpiuegpiuez2878cz65465czezc4z5');

function makeToken($value) {
    return sha1($value.SALT);
}