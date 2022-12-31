<?php

namespace Kikechi\Journals\Traits;

trait JournalSerialNumberFormatter
{
    public string $series;

    public string $sequence;

    public int $sequence_padding;

    public string $delimiter;

    public string $serial_number_format;

    public function series(string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function sequence(int $sequence): self
    {
        $this->sequence = str_pad((string) $sequence, $this->sequence_padding, 0, STR_PAD_LEFT);
        $this->filename($this->getDefaultFilename($this->name));

        return $this;
    }

    public function delimiter(string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function sequencePadding(int $value): self
    {
        $this->sequence_padding = $value;

        return $this;
    }

    public function serialNumberFormat(string $format):self
    {
        $this->serial_number_format = $format;

        return $this;
    }

    public function getSerialNumber(): string
    {
        return strtr($this->serial_number_format, [
            '{SERIES}'    => $this->series,
            '{DELIMITER}' => $this->delimiter,
            '{SEQUENCE}'  => $this->sequence,
        ]);
    }
}