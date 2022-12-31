<?php

namespace Kikechi\Journals\Traits;

use Illuminate\Support\Facades\Storage;

trait JournalSavesFiles
{
    public string $disk;

    public function save(string $disk = ''): self
    {
        if ($disk !== '') {
            $this->disk = $disk;
        }

        $this->render();

        Storage::disk($this->disk)->put($this->filename, $this->output);

        return $this;
    }

    public function url()
    {
        return Storage::disk($this->disk)->url($this->filename);
    }
}