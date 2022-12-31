<?php

namespace Kikechi\Journals\Commands;

use Illuminate\Console\Command;

class InstallJournalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journals:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Journals resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->comment('Publishing Journals Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'journals.assets']);

        $this->comment('Publishing Journals Views...');
        $this->callSilent('vendor:publish', ['--tag' => 'journals.views']);

        $this->comment('Publishing Journals Translations...');
        $this->callSilent('vendor:publish', ['--tag' => 'journals.translations']);

        $this->comment('Publishing Journals Config...');
        $this->callSilent('vendor:publish', ['--tag' => 'journals.config']);

        $this->info('Journals scaffolding installed successfully.');
    }
}