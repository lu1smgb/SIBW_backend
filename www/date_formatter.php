<?php

class DateFormatter {

    // Cambia el formato de la fecha de YYYY-MM-DD a DD/MM/YYYY
    final public function common(string $date) : string
    {
        $aux = str_replace('-','/',$date);
        return date('d/m/Y', strtotime($aux));
    }

    // Formatea un timestamp de SQL al formato DD/MM/YYYY HH:MM
    final function comment(string $date) : string
    {
        return date('d/m/Y H:i', strtotime($date));
    }

}

?>