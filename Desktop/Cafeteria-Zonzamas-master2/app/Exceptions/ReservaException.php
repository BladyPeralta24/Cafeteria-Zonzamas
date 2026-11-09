<?php

namespace App\Exceptions;

use Exception;

/**
 * Error "esperable" al reservar (sin stock, reserva vacía...).
 * Su mensaje se puede enseñar tal cual al usuario.
 */
class ReservaException extends Exception
{
}
