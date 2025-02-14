<?php

namespace App\Enums;

enum StatusEnum: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case OPEN = 3;
    case CLOSED_WITHOUT_PAYMENT = 4;
    case CLOSED_WITH_PAYMENT = 5;

    // HR
    case HIRE = 6; // ishga olish
    case FIRE = 7; // ishdan bo'shatish

    // FIRE
    case NOT_SIGNED = 8; // imzolangan emas
    case SIGNED = 9; // imzolandi

    case PREPAYMENT = 10; // oldindan to'lov
    case FULL_PAYMENT = 11; // to'liq to'lov
    case POST_PAYMENT = 12; // keyin to'lov
    case MONTHLY_PAYMENT = 13; // oylik to'lov

    // PAYMENT
    case PAID_PARTLY = 14; // qisman to'langan
    case INTERN = 15;
}
