<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepartmentControllerTest extends WebTestCase
{

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $email
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($email = 'admin@admin.com', $password = 'admin')
    {
        $client = static::createClient();
        $client->request(
        'GET',
        '/api/login_check',
        array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        json_encode(array(
            'username' => $email,
            'password' => $password,
            ))
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * test getPagesAction
     */
    public function testGetPages()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/department/browse');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTokenInaccessible(): void
    {

         $client = static::createClient();

         $client->request('GET', '/api/department/browse');

         $this->assertEquals(401, $client->getResponse()->getStatusCode());

    }
}
