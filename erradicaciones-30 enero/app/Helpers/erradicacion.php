<?php

if (!function_exists('getMenuActivo')) {
    function getMenuActivo($ruta)
    {
        if (
            (request()->is($ruta)) ||
            (($ruta=='admin/register') && ((Route::current()->getName()=='register_filter') || (Route::current()->getName()=='view_register'))) ||
            (($ruta=='admin/total') && (Route::current()->getName()=='filter_total')) ||
            (($ruta=='admin/graph') && (Route::current()->getName()=='graph_filter')) ||
            (($ruta=='admin/register/registers_map') && (Route::current()->getName()=='registers_map_filter')) ||
            (($ruta=='admin/validation') && ((Route::current()->getName()=='validation') || (Route::current()->getName()=='validation_filter') || (Route::current()->getName()=='view_register_validation'))) ||
            (($ruta=='admin/dispositive') && (Route::current()->getName()=='show_dispositive'))) {
            return 'active ';
        } else {
            return '';
        }
    }
}

if (!function_exists('formatMoney')) {
    // formats money to a whole number or with 2 decimals; includes a dollar sign in front
    function formatMoney($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
        if (is_numeric($number)) { // a number
            if (!$number) { // zero
                $money = ($cents == 2 ? '0.00' : '0'); // output zero
            } else { // value
                if (floor($number) == $number) { // whole number
                $money = number_format($number, ($cents == 2 ? 4 : 0)); // format
                } else { // cents
                $money = number_format(round($number, 4), ($cents == 0 ? 0 : 4)); // format
                } // integer or decimal
            } // value
            return $money;
        } // numeric
    } // formatMoney
}

?>
