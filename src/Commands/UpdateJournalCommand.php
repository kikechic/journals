<?php

namespace Kikechi\Journals\Commands;

use Illuminate\Console\Command;

class UpdateJournalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journals:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Journals Views and Translations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('This will overwrite default templates and translations.');

        if ($this->confirm('Do you wish to continue?')) {
            $this->comment('Updating Journals Views...');
            $this->callSilent('vendor:publish', ['--tag' => 'journals.views', '--force' => true]);

            $this->comment('Updating Journals Translations...');
            $this->callSilent('vendor:publish', ['--tag' => 'journals.translations', '--force' => true]);

            $this->info('Journals Views and Translations updated successfully.');
        }
    }
}