<?php

namespace App\Services;

use App\Models\Application;
use App\Services\Application\ApplicationService;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;

class FileService
{
    public static function deleteExpiredDocs(): bool
    {
        $directories = [
            storage_path('app/public/docs/hire'),
            storage_path('app/public/docs/positions')
        ];

        foreach ($directories as $directory) {
            $files = glob($directory . '/*.docx');

            foreach ($files as $file) {
                $fileExpire = Carbon::parse(filemtime($file))->addMonth();

                if ($fileExpire->isPast()) {
                    unlink($file);
                }
            }
        }

        return true;
    }

    public static function downloadPositionDocs(int $app_id)
    {
        $app = (new ApplicationService())->checkById($app_id);
        if (is_null($app->app_user) || is_null($app->app_user->position_id)) throwError(__('app.position_not_attached'));

        $download_file_path = storage_path('app/public/docs/positions/');
        $search_path = app()->getLocale() == 'ru' ? resource_path('docs/positions/ru') : resource_path('docs/positions/uz');

        $position_file = collect(self::searchFilesByNumber($search_path, $app->app_user->position_id))->first();

        if (is_null($position_file)) {
            $position_file = collect(self::searchFilesByNumber(resource_path('docs/positions'), $app->app_user->position_id))->first();
        }

        if (!file_exists($download_file_path)) mkdir($download_file_path, 0755, true);

        if (!is_null($position_file)) {
            $fio = $app->app_user->surname . ' ' . $app->app_user->name . ' ' . $app->app_user->patronymic;
            $temp = new TemplateProcessor($position_file);
            $temp->setValue('fio', $fio);
            $temp->setValue('app_date', Carbon::parse($app->hire_date)->format('d.m.Y'));
            $temp->saveAs($download_file_path . $fio . '.docx');

            return response()->download($download_file_path . $fio . '.docx');
        }

        throwError(__('app.position_file_does_not_exists'));
        return null;
    }

    public static function searchFilesByNumber(string $directory, string $number): array
    {
        $files = glob($directory . '/*.docx');

        return array_filter($files, function ($file) use ($number) {
            $name = basename($file);
            return preg_match('/\b' . preg_quote($number, '/') . '\b/', $name);
        });
    }

    public static function downloadHireDocs(string $type, array $data)
    {
        $file = null;
        $download_file_path = storage_path('app/public/docs/hire/');

        if (!file_exists($download_file_path)) mkdir($download_file_path, 0755, true);

        switch ($type) {
            case 'mat':
                $file = resource_path('docs/hire/' . 'mat_' . app()->getLocale() . '.docx');
                break;
            case 'nda':
                $file = resource_path('docs/hire/' . 'nda_' . app()->getLocale() . '.docx');
                break;
            case 'priyom_prikaz':
                $file = resource_path('docs/hire/' . 'prikaz_' . app()->getLocale() . '.docx');
                break;
            case 'trudovoy':
                $file = resource_path('docs/hire/' . 'trudovoy_' . app()->getLocale() . '.docx');
                break;
            case 'entrance':
                $file = resource_path('docs/hire/' . 'zayavlenie_' . app()->getLocale() . '.docx');
                break;
            case 'dismissal':
                $file = resource_path('docs/hire/' . 'uvolnenie_' . app()->getLocale() . '.docx');
                break;
            case 't2-1':
                $file = resource_path('docs/hire/' . 't2-1' . '.docx');
                break;
            case 't2-2':
                $file = resource_path('docs/hire/' . 't2-2' . '.docx');
                break;
            default:
                throwError(__('app.file_not_found'));
        }

        if (!file_exists($file)) throwError(__('app.file_not_found'));

        $position_code = '____________';
        if (preg_match('/\b[A-Z]{3,10}\s*-\s*\d\b/', $data['position'], $matches)) {
            $position_code = preg_replace('/\s*/', '', $matches[0]);
        }

        $trudovoy_director = app()->getLocale() == 'ru' ? 'директору магазина' : 'дукон директорига бўйсунади';
        $contr_text = app()->getLocale() == 'uz' ? 'Шартноманинг амал қилиш муддати' : 'Срок Договора';
        $duration_text = app()->getLocale() == 'uz' ? '(синов муддати 3 ой).' : '(с испытательным сроком на 3 месяца).';
        $duration_text2 = app()->getLocale() == 'uz' ? ' синов муддати 3 ой,' : 'с испытательным сроком на 3 месяца';

        if (isset($data['app_id'])) {
            $app = Application::with(['app_user', 'form.personal_data'])->find($data['app_id']);
            $phone = $app->app_user->phone ?? null;

            if ($app->form) {
                $birth_date = Carbon::parse($app->form->personal_data->birth_date)->format('d.m.Y');
                $birth_address = $app->form->personal_data->birth_address;
            }

            $contr_duration = $app->contract_duration;
            $intern_duration = $app->intern_duration;

            if (!is_null($contr_duration)) {
                $contr_text .= ": " . $contr_duration;
            } else {
                $contr_text .= app()->getLocale() == 'uz' ? ' белгиланмаган' : ' неопределенный';
            }

            if ($app->app_user) {
                if (in_array($app->app_user->position_id, [369, 370, 371])) {
                    $trudovoy_director = app()->getLocale() == 'ru' ? 'руководителю отдела по продвежению товара' : 'маҳсулотни ривожлантириш бўлими бошлиғига бўйсунади';
                } else if (in_array($app->app_user->position_id, [207, 208, 209])) {
                    $trudovoy_director = app()->getLocale() == 'ru' ? 'руководителю отдела по подбору и адаптации персонала' : 'ходимларни ёнлаш ва мослаштириши бўлими бошлиғига бўйсунади';
                }
            }
        }

        $temp = new TemplateProcessor($file);
        $temp->setValue('fio', $data['fio']);
        $temp->setValue('short_fio', $data['short_fio']);
        $temp->setValue('fio_cyrilic', translit($data['fio'], "oz")['cyr']);
        $temp->setValue('name', $data['fio']);
        $temp->setValue('surname', $data['fio']);
        $temp->setValue('patronymic', $data['fio']);
        $temp->setValue('phone', $phone ?? null);
        $temp->setValue('birth_date', $birth_date ?? null);
        $temp->setValue('birth_address', $birth_address ?? null);
        $temp->setValue('passport_code', $data['passport_code'] ?? "");
        $temp->setValue('passport_number', $data['passport_number'] ?? "");
        $temp->setValue('passport_date', $data['passport_date'] ?? "");
        $temp->setValue('position', $data['position']);
        $temp->setValue('position_code', $position_code);
        $temp->setValue('work_place', $data['work_place']);
        $temp->setValue('app_date', $data['app_date']);
        $temp->setValue('app_date_ymd', $data['app_date_ymd']);
        $temp->setValue('current_date_ymd', Carbon::now()->format('d.m.Y'));
        $temp->setValue('current_date_ymd', Carbon::now()->format('d.m.Y'));
        $temp->setValue('trudovoy_director', $trudovoy_director);
        $temp->setValue('contract_text', $contr_text);
        $temp->setValue('duration_text', $intern_duration ?? null == 0 ? $duration_text : '');
        $temp->setValue('duration_text2', $intern_duration ?? null == 0 ? $duration_text2 : '');
        $temp->setValue('duration_text', $duration_text);
        $temp->setValue('duration_text2', $duration_text2);
        $temp->saveAs($download_file_path . $data['fio'] . '.docx');

        return response()->download($download_file_path . $data['fio'] . '.docx');
    }
}
