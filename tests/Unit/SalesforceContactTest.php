<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

/**
 * Test salesforce contact model
 *
 * Class SalesforceContactTest
 * @package Tests\Unit
 */
class SalesforceContactTest extends TestCase
{

    /**
     * @var SalesforceContact mock object
     */
    protected $salesforceContactMock;

    /**
     * set up
     */
    public function setUp(): void
    {
        parent::setUp();

        // set up our SalesforceContact mock
        $this->salesforceContactMock = Mockery::mock(
            'App\SalesforceContact'
        )->makePartial();
    }

    /**
     * test getContacts
     */

    /**
     * test getContacts
     *
     * @dataProvider getContactsProvider
     * @param $offset
     * @param $limit
     * @param $expected
     */
    public function testGetContacts($offset, $limit, $expected)
    {
        // set up what our query should look like
        $query = "SELECT Id, Name FROM Contact LIMIT {$limit} OFFSET {$offset}";

        // Forrest should receive query call with our query and return our expected result
        Forrest::shouldReceive('query')
            ->once()
            ->with($query)
            ->andReturn($expected);

        // get the actual result from our mocked object
        $actual = $this->salesforceContactMock->getContacts($offset, $limit);

        // assert that our expected matches our actual
        $this->assertEquals($expected, $actual);
    }

    /**
     * getContacts data provider
     *
     * @return array
     */
    public function getContactsProvider()
    {
        return [
            'get 1 record' => [
                // offset
                0,
                // limit
                1,
                // result
                [
                    'total' => 1,
                    'results' => [
                        [
                            'Id' => '1234abc',
                            'Name' => 'Darth Vader',
                        ],
                    ],
                ],
            ],
            'get 4 records' => [
                // offset
                5,
                // limit
                4,
                // result
                [
                    'total' => 4,
                    'results' => [
                        [
                            'Id' => '1234abc',
                            'Name' => 'Darth Vader',
                        ],
                        [
                            'Id' => '10987zyx',
                            'Name' => 'Han Solo'
                        ],
                        [
                            'Id' => '56789lmn',
                            'Name' => 'Chewbacca'
                        ],
                        [
                            'Id' => 'TK-421',
                            'Name' => 'Luke Skywalker'
                        ],
                    ],
                ],
            ],
        ];
    }
}
