<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleApiControllerTest extends WebTestCase
{

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $email
     * @param string $password
     *
     * @return Client
     */
    protected function createAuthenticatedClient($email = 'admin@admin.com', $password = 'admin')
    {

        $client = static::createClient();

        //HTTP header construction
        //simulates a request from the front, so that the token is returned
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

        //transforms into an associative array what the response returns
        $data = json_decode($client->getResponse()->getContent(), true);

        //authentification
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     *
     * @dataProvider urlProviderAdminGetSuccessful
     */
    public function testGetPages($url)
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider urlProviderAdminGetSuccessful
     */
    public function testTokenInaccessible($url): void
    {

         $client = static::createClient();

         $client->request('GET', $url);

         $this->assertEquals(401, $client->getResponse()->getStatusCode());

    }

    public function urlProviderAdminGetSuccessful()
    {
        yield ['/api/department/browse'];
        yield ['/api/place/category/browse'];
        yield ['/api/place/category/read/1'];
        yield ['/api/place/browse'];
        yield ['/api/place/read/1'];
        yield ['/api/product/category/browse'];
        yield ['/api/product/category/read/1'];
    }
}
