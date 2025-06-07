<?php

namespace App;

enum RoleType: string
{
    case SUPER_ADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case VOTER = 'Voter';
    case ORGANISER = 'Organiser';
}
