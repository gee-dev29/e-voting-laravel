<?php

namespace App\Enum;

enum RoleType: string
{
    case SUPER_ADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case VOTER = 'Voter';
    case ORGANISER = 'Organiser';
}
