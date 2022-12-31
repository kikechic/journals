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

    public string $invoice_date;

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

    public function debit(): self
    {
        $this->debit = $this->entry_type === 'D' ? $this->amount : null;

        return $this;
    }

    public function  credit(): self
    {
        $this->credit = $this->entry_type === 'C' ? $this->amount : null;

        $this;
    }

    public function currency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function invoiceDate(string $date): self
    {
        $this->invoice_date = $date;

        return $this;
    }
}