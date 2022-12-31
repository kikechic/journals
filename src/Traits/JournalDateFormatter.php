<?php

namespace Kikechi\Journals\Traits;

use Carbon\Carbon;

trait JournalDateFormatter
{
    public Carbon $date;

    public string $date_format;

    public function date(Carbon $date): self
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
        return $this->date->format($this->date_format);
    }

}