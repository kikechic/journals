<?php

namespace Kikechi\Journals;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Kikechi\Journals\Classes\JournalItem;
use Kikechi\Journals\Classes\JournalParty;
use Kikechi\Journals\Contracts\JournalPartyContract;
use Kikechi\Journals\Traits\JournalCurrencyFormatter;
use Kikechi\Journals\Traits\JournalDateFormatter;
use Kikechi\Journals\Traits\JournalHelpers;
use Kikechi\Journals\Traits\JournalSavesFiles;
use Kikechi\Journals\Traits\JournalSerialNumberFormatter;

class Journal
{
    use JournalCurrencyFormatter;
    use JournalDateFormatter;
    use JournalHelpers;
    use JournalSavesFiles;
    use JournalSerialNumberFormatter;

    public const TABLE_COLUMNS = 4;

    public string $name;

    public JournalPartyContract $seller;

    public Collection $items;

    public string $template;

    public string $filename;

    public string $notes;

    public string $logo;

    public mixed $debit;

    public mixed $credit;

    public string $account;

    public string $currency;

    public float $total_debits;

    public float $total_credits;

    public int $table_columns;

    /**
     * @var Pdf
     */
    public $pdf;

    public string $output;

    protected mixed $userDefinedData;

    /**
     * Invoice constructor.
     *
     * @param string $name
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $name = '')
    {
        // Invoice
        $this->name     = $name ?: __('journals::journal.journal');
        $this->seller   = app()->make(config('journals.seller.class'));
        $this->items    = Collection::make([]);
        $this->template = 'default';

        // Date
        $this->date           = Carbon::now();
        $this->date_format    = config('journals.date.format');

        // Serial Number
        $this->series               = config('journals.serial_number.series');
        $this->sequence_padding     = config('journals.serial_number.sequence_padding');
        $this->delimiter            = config('journals.serial_number.delimiter');
        $this->serial_number_format = config('journals.serial_number.format');
        $this->sequence(config('journals.serial_number.sequence'));

        // Filename
        $this->filename($this->getDefaultFilename($this->name));

        // Currency
        $this->currency_code                = config('journals.currency.code');
        $this->currency_fraction            = config('journals.currency.fraction');
        $this->currency_symbol              = config('journals.currency.symbol');
        $this->currency_decimals            = config('journals.currency.decimals');
        $this->currency_decimal_point       = config('journals.currency.decimal_point');
        $this->currency_thousands_separator = config('journals.currency.thousands_separator');
        $this->currency_format              = config('journals.currency.format');

        $this->disk          = config('journals.disk');
        $this->table_columns = static::TABLE_COLUMNS;
    }

    /**
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Journal
     */
    public static function make(string $name = '')
    {
        return new static($name);
    }

    public static function makeParty(array $attributes = []): JournalParty
    {
        return new JournalParty($attributes);
    }

    public static function makeItem(string $description = ''): JournalItem
    {
        return (new JournalItem())->description($description);
    }

    public function addItem(JournalItem $item): self
    {
        $this->items->push($item);

        return $this;
    }

    public function addItems($items): self
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @throws Exception
     *
     */
    public function render(): self
    {
        if ($this->pdf) {
            return $this;
        }

        $this->beforeRender();

        $template = sprintf('journals::templates.%s', $this->template);
        $view     = View::make($template, ['journal' => $this]);
        $html     = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $this->pdf    = Pdf::setOption(['enable_php' => true])->loadHtml($html);
        $this->output = $this->pdf->output();

        return $this;
    }

    public function toHtml()
    {
        $template = sprintf('journals::templates.%s', $this->template);

        return View::make($template, ['journal' => $this]);
    }

    /**
     * @throws Exception
     *
     * @return Response
     */
    public function stream()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->filename . '"',
        ]);
    }

    /**
     * @throws Exception
     *
     * @return Response
     */
    public function download()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $this->filename . '"',
            'Content-Length'      => strlen($this->output),
        ]);
    }
}
