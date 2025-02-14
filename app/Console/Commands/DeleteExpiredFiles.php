<?php

namespace App\Console\Commands;

use App\Services\FileService;
use Illuminate\Console\Command;

class DeleteExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eski docx fayllarni o\'chirish';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        FileService::deleteExpiredDocs();
    }
}
