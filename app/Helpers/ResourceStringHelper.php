<?php

namespace App\Helpers;

use App\Models\Address;
use App\Models\Contact;


class ResourceStringHelper
{
    public static function address(Address $address): string
    {
        $result = $address->street_number . ' ' . $address->street . ', ' . $address->postcode;

        if ($address->building) {
            $result .= ', Building ' . $address->building;
        }

        if ($address->floor) {
            $result .= ', Floor ' . $address->floor;
        }

        if ($address->unit) {
            $result .= ', Unit ' . $address->unit;
        }

        return $result;
    }

    public static function contact(Contact $contact): string
    {
        $result = $contact->email;

        if ($contact->mobile) {
            $result .= ', Mobile ' . $contact->mobile;
        }

        if ($contact->landline) {
            $result .= ', Landline ' . $contact->landline;
        }

        if ($contact->url) {
            $result .= ', URL ' . $contact->url;
        }

        return $result;
    }
}
