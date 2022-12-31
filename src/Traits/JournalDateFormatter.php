<?php

namespace Kikechi\Journals\Traits;

use Carbon\Carbon;

trait JournalDateFormatter
{
    public string|Carbon $date;

    public string $date_format;

    public function date(string|Carbon $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function dateFormat(string $format): self
    {
        $this->date_format = $format;

        return $this;
    }

    public function getDate(): mixed
    {
        if ($this->date instanceof Carbon) {
            return $this->date->format($this->date_format);
        }

        return $this->date;
    }

}