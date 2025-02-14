<?php

namespace App\Enums;

enum AppStepEnum: int
{
    // HR
    case SAVED = 7; // saqlangan (DIREKTOR)
    case IN_VIEW = 8; // ko'rib chiqilmoqda (DIREKTOR)
    case REJECTED = 9; // rad etildi (HR)
    case READY_TO_SIGN = 10; // imzolashga tayyor (HR)
    case PENDING_APPROVAL = 11; // tasdiqlashni kutmoqda (DIREKTOR)

    // FIRE
    case SENT_TO_WORKLOAD = 12; // Aylanma varaqga yuborish (DIREKTOR)
    case PENDING_TO_SIGN = 13; // imzolashni kutmoqda

    // JAMSHID AKA
    case FOR_JAMSHID_AKA = 14; // Jamshid aka uchun (HR)
    case FINAL_APPROVAL = 15; // Jamshid aka tasdiqlagan

    // HR
    case DOCS_ACCEPTED = 16; // hujjatlar tasdiqlandi (HR)
    case DOCS_SEND_EMAIL = 17; // hujjatlar emaildan jo'natildi (DIREKTOR)
}
