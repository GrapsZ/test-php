<?php

namespace App\Services\Dates;

use DateTime;

class DatesChecker
{
    /**
     * Fonction qui test la validité d'une date en fonction de son format.
     * @param $date
     * @param string $format
     * @return DateTime|false
     */
    public function checkDateFormat($date, $format = "Y-m-d H:i")
    {
        $checkedDate = $this->getDateTime($date, $format);

        return ($checkedDate);
    }

    /**
     * Retourne un Datetime ou false si la varaible $date n'était pas bien formatée
     * @param $date
     * @param string $format
     * @return DateTime|false
     */
    public function getDateTime($date, $format = "Y-m-d H:i")
    {
        return DateTime::createFromFormat($format, $date);
    }
}