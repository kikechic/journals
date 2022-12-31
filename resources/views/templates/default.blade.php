<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $journal->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
            font-size: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans", serif;
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        tr,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }
    </style>
</head>

<body>
{{-- Header --}}
@if($journal->logo)
    <img src="{{ $journal->getLogo() }}" alt="logo" height="100">
@endif

<table class="table mt-5">
    <tbody>
    <tr>
        <td class="border-0 pl-0" style="width: 70%">
            <h4 class="text-uppercase">
                <strong>{{ $journal->name }}</strong>
            </h4>
        </td>
        <td class="border-0 pl-0">
            <p>{{ __('journals::journal.serial') }} <strong>{{ $journal->getSerialNumber() }}</strong></p>
            <p>{{ __('journals::journal.date') }}: <strong>{{ $journal->getDate() }}</strong></p>
        </td>
    </tr>
    </tbody>
</table>

{{-- Seller - Buyer --}}
<table class="table">
    <thead>
    <tr>
        <th class="border-0 pl-0 party-header" style="width: 48.5%">
            {{ __('journals::journal.seller') }}
        </th>
        <th class="border-0" style="width: 3%"></th>
        <th class="border-0 pl-0 party-header">
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="px-0">
            @if($journal->seller->name)
                <p class="seller-name">
                    <strong>{{ $journal->seller->name }}</strong>
                </p>
            @endif

            @if($journal->seller->address)
                <p class="seller-address">
                    {{ __('journals::journal.address') }}: {{ $journal->seller->address }}
                </p>
            @endif

            @if($journal->seller->code)
                <p class="seller-code">
                    {{ __('journals::journal.code') }}: {{ $journal->seller->code }}
                </p>
            @endif

            @if($journal->seller->vat)
                <p class="seller-vat">
                    {{ __('journals::journal.vat') }}: {{ $journal->seller->vat }}
                </p>
            @endif

            @if($journal->seller->phone)
                <p class="seller-phone">
                    {{ __('journals::journal.phone') }}: {{ $journal->seller->phone }}
                </p>
            @endif

            @foreach($journal->seller->custom_fields as $key => $value)
                <p class="seller-custom-field">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>

{{-- Table --}}
<table class="table table-items">
    <thead>
    <tr>
        <th scope="col" class="border-0 pl-0">{{ __('journals::journal.number') }}</th>
        <th scope="col" class="border-0 pl-0">{{ __('journals::journal.invoice_date') }}</th>
        <th scope="col" class="text-center border-0">{{ __('journals::journal.account') }}</th>
        <th scope="col" class="text-center border-0">{{ __('journals::journal.description') }}</th>
        <th scope="col" class="text-center border-0">{{ __('journals::journal.currency') }}</th>
        <th scope="col" class="text-center border-0">{{ __('journals::journal.debit') }}</th>
        <th scope="col" class="text-right border-0">{{ __('journals::journal.credit') }}</th>
    </tr>
    </thead>
    <tbody>
    {{-- Items --}}
    @foreach($journal->items as $item)
        <tr>
            <td class="pl-0">
                {{ $loop->iteration }}
            </td>
            <td class="text-center">
                {{ $item->invoice_date }}
            </td>
            <td class="text-center">
                {{ $item->account }}
            </td>
            <td class="text-center">
                {{ $item->description }}
            </td>
            <td class="text-center">
                {{ $item->currency }}
            </td>
            <td class="text-right">
                {{ $item->debit_amount }}
            </td>
            <td class="text-right">
                {{ $item->credit_amount }}
            </td>
        </tr>
    @endforeach

    {{-- Summary --}}
    <tr>
        <td colspan="{{ $journal->table_columns - 3 }}" class="border-0"></td>
        <td class="text-right pl-0">{{ __('journals::journal.total_amount') }}</td>
        <td class="text-right pr-0 total-amount">
            {{ $journal->credit_total_amount }}
        </td>
        <td class="text-right pr-0 total-amount">
            {{ $journal->credit_total_amount }}
        </td>
    </tr>
    </tbody>
</table>

@if($journal->notes)
    <p>
        {{ trans('journals::journal.notes') }}: {!! $journal->notes !!}
    </p>
@endif

<script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
            $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width);
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>