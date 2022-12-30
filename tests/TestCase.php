<?php

namespace Kikechi\Journals\Tests;

use Kikechi\Journals\JournalsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            JournalServiceProvider::class,
        ];
    }
}
