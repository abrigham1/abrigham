<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\View;
use Mockery;
use App\SalesforceContact;
use Omniphx\Forrest\Exceptions\MissingTokenException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SalesforceDemoControllerTest extends TestCase
{
    /**
     * @var SalesforceContact mock object
     */
    protected $salesforceContactMock;

    /**
     * @var SalesforceDemonController mock object
     */
    protected $salesforceDemoControllerMock;

    /**
     * set up
     */
    public function setUp()
    {
        parent::setUp();
        // set up our SalesforceContact mock
        $this->salesforceContactMock = Mockery::mock(
            'App\SalesforceContact'
        )->makePartial();
    }

    /**
     * test show with an exception
     */
    public function testShowException()
    {
        // set up our uri to test with
        $uri = route('salesforce-demo', [], false);

        // set up our uri that we expect to be redirected to
        $redirectUri = route('salesforce-authenticate', [], false);

        // set up our exception
        $exception = new MissingTokenException('test exception');

        // swap our apps instance of SalesforceContact with the mock
        $this->app->instance(SalesforceContact::class, $this->salesforceContactMock);

        // if we have an exception instead of calling view we expect to redirect to authenticate
        $this->salesforceContactMock->shouldReceive('getContacts')
            ->once()
            ->withNoArgs()
            ->andThrow($exception);

        // lets call our uri and get a response
        $response = $this->get($uri);

        // assert that we did actually get redirected
        $response->assertRedirect($redirectUri);
    }

    /**
     * test show with no exception
     */
    public function testShowNoException()
    {
        // set up our uri to test with
        $uri = route('salesforce-demo', [], false);

        // set up some mock contact info
        $contacts = [
            'totalSize' => 1,
            'records' => 'test'
        ];

        // swap our apps instance of SalesforceContact with the mock
        $this->app->instance(SalesforceContact::class, $this->salesforceContactMock);

        // if there is no exceptions we should get a view with our total contacts and contacts assigned
        $this->salesforceContactMock->shouldReceive('getContacts')
            ->once()
            ->withNoArgs()
            ->andReturn($contacts);

        // lets call our uri and get a response
        $response = $this->get($uri);

        // assert that we should get the salesforce_demo view
        $response->assertViewIs('salesforce_demo');

        // assert that the data from getContacts should have been passed to it
        $response->assertViewHasAll(
            [
                'totalContacts' => $contacts['totalSize'],
                'contacts' => $contacts['records'],
            ]
        );
    }
}