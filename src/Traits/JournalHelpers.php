<?php

namespace Kikechi\Journals\Traits;

use Exception;
use Illuminate\Support\Str;
use Kikechi\Journals\Contracts\JournalPartyContract;

trait JournalHelpers
{
    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function notes(string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function logo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function seller(JournalPartyContract $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function buyer(JournalPartyContract $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function setCustomData(mixed $value):self
    {
        $this->userDefinedData = $value;

        return $this;
    }

    public function getCustomData()
    {
        return $this->userDefinedData;
    }

    public function template(string $template = 'default'): self
    {
        $this->template = $template;

        return $this;
    }

    public function filename(string $filename): self
    {
        $this->filename = sprintf('%s.pdf', $filename);

        return $this;
    }

    public function getTotalAmountInWords(): mixed
    {
        return $this->getAmountInWords($this->total_amount);
    }

    public function getLogo(): string
    {
        $type = pathinfo($this->logo, PATHINFO_EXTENSION);
        $data = file_get_contents($this->logo);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function applyColspan(): void
    {
        // (!$this->hasItemUnits) ?: $this->table_columns++;
    }

    /**
     * @return string
     */
    protected function getDefaultFilename(string $name): string
    {
        if ($name === '') {
            return sprintf('%s_%s', $this->series, $this->sequence);
        }

        return sprintf('%s_%s_%s', Str::snake($name), $this->series, $this->sequence);
    }

    /**
     * @throws Exception
     */
    protected function beforeRender(): void
    {
        $this->validate();
        $this->calculate();
    }

    /**
     * @throws Exception
     */
    protected function validate()
    {
        if (!$this->seller) {
            throw new Exception('Seller not defined.');
        }

        if (!count($this->items)) {
            throw new Exception('No items to journal defined.');
        }
    }

    protected function calculate(): self
    {
        $this->items->each(function ($item) {
            $this->total_debits += $item->debit;
            $this->total_credits += $item->credit;
        });

        $this->applyColspan();

        return $this;
    }
}