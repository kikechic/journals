<?php

namespace Kikechi\Journals\Classes;

use Kikechi\Journals\Contracts\JournalPartyContract;

class JournalParty implements JournalPartyContract
{
    public array $custom_fields;

    /**
     * Party constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->custom_fields = [];

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->{$key} ?? null;
    }
}