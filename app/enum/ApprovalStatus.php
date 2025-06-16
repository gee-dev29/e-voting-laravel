<?php

namespace App\Enum;

enum ApprovalStatus: string
{
  case PENDING_APPROVAL = 'Pending Approval';
  case APPROVED = 'Approved';
  case REJECTED = 'Rejected';
}
