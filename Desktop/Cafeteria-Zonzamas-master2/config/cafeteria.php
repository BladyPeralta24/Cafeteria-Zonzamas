<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Horario de recogida
    |--------------------------------------------------------------------------
    | Franja en la que se pueden recoger los pedidos (formato H:i) y minutos
    | mínimos de antelación con los que hay que reservar.
    */
    'hora_apertura' => env('CAFETERIA_APERTURA', '08:00'),
    'hora_cierre' => env('CAFETERIA_CIERRE', '14:30'),
    'minutos_antelacion' => (int) env('CAFETERIA_ANTELACION', 5),

    /*
    |--------------------------------------------------------------------------
    | IGIC
    |--------------------------------------------------------------------------
    | Los precios de la carta ya incluyen el IGIC. Este porcentaje solo se usa
    | para desglosar el impuesto en el resumen de la reserva.
    */
    'igic' => (float) env('CAFETERIA_IGIC', 7),

    /*
    |--------------------------------------------------------------------------
    | Límites
    |--------------------------------------------------------------------------
    */
    'max_unidades_por_producto' => 10,

];
