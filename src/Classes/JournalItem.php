<?php

namespace Kikechi\Journals\Classes;

use Exception;

class JournalItem
{
    public string $description;

    public string $account;

    public float $amount;

    public string $entry_type;

    public float|null $debit;

    public float|null $credit;

    public string $currency;

    /**
     * InvoiceItem constructor.
     */
    public function __construct()
    {
        $this->amount = 0.0;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function account(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function amount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function entryType(string $entry_type): self
    {
        $this->entry_type = $entry_type;

        return $this;
    }

    public function debit(): void
    {
        $this->debit = $this->entry_type === 'D' ? $this->amount : null;
    }

    public function  credit(): void
    {
        $this->credit = $this->entry_type === 'C' ? $this->amount : null;
    }
}