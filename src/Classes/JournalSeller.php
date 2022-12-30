<?php

namespace Kikechi\Journals\Classes;

use Kikechi\Journals\Contracts\JournalPartyContract;

class JournalSeller implements JournalPartyContract
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $name;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $address;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $code;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $vat;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $phone;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $custom_fields;

    /**
     * Seller constructor.
     */
    public function __construct()
    {
        $this->name          = config('journals.seller.attributes.name');
        $this->address       = config('journals.seller.attributes.address');
        $this->code          = config('journals.seller.attributes.code');
        $this->vat           = config('journals.seller.attributes.vat');
        $this->phone         = config('journals.seller.attributes.phone');
        $this->custom_fields = config('journals.seller.attributes.custom_fields');
    }
}