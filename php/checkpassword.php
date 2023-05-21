<?php 

$home = 'salzburg';

if ($_GET['username'] == 'ardalan' && $_GET['password'] == '12345') {
    echo 'passt';
    
} else {
    print_r('nein');
}
