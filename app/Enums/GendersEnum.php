<?php

namespace App\Enums;

enum GendersEnum: string
{
    case Male = 'male';
    case Female = 'female';
    case Another = 'another';

    public function getName(string $case)
    {
        return match ($case) {
            'male' => 'Homem',
            'female' => 'Mulher',
            'another' => 'Não informado'
        };
    }
}
