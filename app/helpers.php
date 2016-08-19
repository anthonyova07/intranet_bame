<?php

function clear_str($str) {
    return strtolower(trim($str));
}

function cap_str($str) {
    return ucwords(clear_str($str));
}

function get_status($status) {
    return $status ? 'A' : 'I';
}

function get_web($web) {
    return $web ? 'S' : 'N';
}
