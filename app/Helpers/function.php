<?php

if (!function_exists('dateTimeToBR')) {

    function dateTimeToBR($dateTime)
    {
        $date = new DateTime($dateTime);
        return $date->format('d/m/Y H:i');
    }
}

if (!function_exists('getLabelForBinary')) {

    function getLabelForBinary($val)
    {
        return ($val == 0) ? 'Sim' : 'Não';
    }
}

if (!function_exists('getStatusReport')) {

    function getStatusReport($status = 0)
    {
        $statusArr = [
            1 => 'Novo',
            2 => 'Em Andamento',
            3 => 'Finalizado',
            4 => 'Cancelado'
        ];

        if($status)
            return $statusArr[$status];

        return $statusArr;
    }
}
