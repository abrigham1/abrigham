<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use \Exception;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;
use App\SalesforceContact;
use Omniphx\Forrest\Exceptions\MissingTokenException;

/**
 * Class SalesforceDemoController
 * @package App\Http\Controllers
 */
class SalesforceDemoController extends Controller
{

    /**
     * @var SalesforceContact
     */
    protected $salesforceContact;

    public function __construct(SalesforceContact $salesforceContact)
    {
        $this->salesforceContact = $salesforceContact;
    }

    /**
     * authenticate with salesforce
     *
     * @return mixed
     */
    public function authenticate()
    {
        // lets authenticate with salesforce using the omniphx/forrest package
        return Forrest::authenticate();
    }

    /**
     * callback from salesforce (store the authentication token)
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        // run the callback to exchange our code for an authentication token which then gets stored
        Forrest::callback();

        // redirect to our salesforce demo page now that we are authenticated yay
        return redirect()->route('salesforce-demo');
    }

    /**
     * show the salesforce demo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show()
    {
        try {
            // lets try to query the contacts
            $contacts = $this->salesforceContact->getContacts();

            // return our view with our contacts attached
            return view(
                'salesforce_demo',
                [
                    'totalContacts' => $contacts['totalSize'],
                    'contacts' => $contacts['records'],
                ]
            );
        } catch (MissingTokenException $e) {
            // if we are missing the authentication token we need to authenticate
            // if any other type of exception occurs lets let it fall through
            // to the laravel handler so devs will be emailed since we dont know how
            // to fix them for now.
            return redirect()->route('salesforce-authenticate');
        }
    }
}