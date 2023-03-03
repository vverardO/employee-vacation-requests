<?php

namespace App\Enums;

enum RequestStatus: string
{
    case Opened = 'opened';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getName(string $case)
    {
        return match ($case) {
            'opened' => 'Aberta',
            'approved' => 'Aprovada',
            'rejected' => 'Rejeitada'
        };
    }

    public function getColor(string $case)
    {
        return match ($case) {
            'opened' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger'
        };
    }
}
