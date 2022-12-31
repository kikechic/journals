<?php

namespace Kikechi\Journals\Traits;

use NumberFormatter;

trait JournalCurrencyFormatter
{
    public string $currency_code;

    public string $currency_fraction;

    public string $currency_symbol;

    public int $currency_decimals;

    public string $currency_decimal_point;

    public string $currency_thousands_separator;

    public string $currency_format;

    public function currencyCode(string $code): self
    {
        $this->currency_code = $code;

        return $this;
    }

    public function currencyFraction(string $name): self
    {
        $this->currency_fraction = $name;

        return $this;
    }

    public function currencySymbol(string $symbol): self
    {
        $this->currency_symbol = $symbol;

        return $this;
    }

    public function currencyDecimals(int $decimals): self
    {
        $this->currency_decimals = $decimals;

        return $this;
    }

    public function currencyDecimalPoint(string $decimal_point): self
    {
        $this->currency_decimal_point = $decimal_point;

        return $this;
    }

    public function currencyThousandsSeparator(string $thousands_separator): self
    {
        $this->currency_thousands_separator = $thousands_separator;

        return $this;
    }

    public function currencyFormat(string $format): self
    {
        $this->currency_format = $format;

        return $this;
    }

    public function formatCurrency(float $amount): string
    {
        $value = number_format(
            $amount,
            $this->currency_decimals,
            $this->currency_decimal_point,
            $this->currency_thousands_separator
        );

        return strtr($this->currency_format, [
            '{VALUE}'  => $value,
            '{SYMBOL}' => $this->currency_symbol,
            '{CODE}'   => $this->currency_code,
        ]);
    }

    public function getAmountInWords(float $amount, ?string $locale = null): string
    {
        $amount    = number_format($amount, $this->currency_decimals, '.', '');
        $formatter = new NumberFormatter($locale ?? App::getLocale(), NumberFormatter::SPELLOUT);

        $value = explode('.', $amount);

        $integer_value  = (int) $value[0] !== 0 ? $formatter->format($value[0]) : 0;
        $fraction_value = isset($value[1]) ? $formatter->format($value[1]) : 0;

        if ($this->currency_decimals <= 0) {
            return sprintf('%s %s', ucfirst($integer_value), strtoupper($this->currency_code));
        }

        return sprintf(
            trans('journals::journal.amount_in_words_format'),
            ucfirst($integer_value),
            strtoupper($this->currency_code),
            $fraction_value,
            $this->currency_fraction
        );
    }
}