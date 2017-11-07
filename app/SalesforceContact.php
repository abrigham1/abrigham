<?php

namespace App;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

/**
 * This is just a place to organize calls related to the salesforce contact object
 * which could include inserts, deletes, and selects among other things
 *
 * Class SalesforceContact
 * @package App
 */
class SalesforceContact
{

    /**
     * get contacts
     *
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function getContacts($offset = 0, $limit = 50)
    {
        // query the contacts with soql and return the result
        $results = Forrest::query("SELECT Id, Name FROM Contact LIMIT {$limit} OFFSET {$offset}");
        return $results;
    }
}
