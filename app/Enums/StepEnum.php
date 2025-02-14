<?php

namespace App\Enums;

enum StepEnum: int
{
    case NEW = 0; // yangi
    case ATTACHED = 1; // biriktirilgan
    case NON_ATTACHED = 2; // biriktirilmagan
    case APPROVED = 3; // tasdiqlangan
    case IN_REGISTRY = 4; // reestrda
    case SENT_FOR_PAYMENT = 5; // to'lov uchun yuborilgan
    case PAYMENT_ACCEPTED = 6; // to'lov tasdiqlandi

    // HR
    case SAVED = 7; // saqlangan
    case IN_VIEW = 8; // ko'rib chiqilmoqda
    case REJECTED = 9; // rad etildi
    case READY_TO_SIGN = 10; // imzolashga tayyor
    case PENDING_APPROVAL = 11; // tasdiqlashni kutmoqda

    // FIRE
    case SENT_TO_WORKLOAD = 12; // Aylanma varaqga yuborish
    case PENDING_TO_SIGN = 13; // imzolashni kutmoqda

    case FOR_JAMSHID_AKA = 14; // Jamshid aka uchun
    case FINAL_APPROVAL = 15; // Jamshid aka tasdiqlagan

    // INVOICE
    case FINANCE_INVOICE_APPROVED = 16; // finance fakturani tasdiqladi
    case ACCEPTED = 17; // qabul qilindi
}
