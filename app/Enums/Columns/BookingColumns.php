<?php

namespace App\Enums\Columns;

enum BookingColumns: string
{
    case ID = 'ID';
    case NUMBER = 'Number';
    case STATUS = 'Status';
    case SERVICE_TYPE = 'Service Type';
    case PRIORITY = 'Priority';
    case APPOINTMENT_START = 'Appointment Start At';
    case APPOINTMENT_FINISH = 'Appointment Finish At';
    case ESTIMATED_DURATION = 'Estimated Duration';
    case ESTIMATED_COST = 'Estimated Cost';
    
}
