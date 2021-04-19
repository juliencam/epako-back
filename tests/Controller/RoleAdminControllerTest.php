<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleAdminControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProviderAdminGetSuccessful
     */
    public function testAdminGetSuccessful($url)
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@admin.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    /**
     * @dataProvider urlProviderAdminGetSuccessful
     */
    public function testAdminInaccessible($url): void
    {

         $client = static::createClient();

         $client->request('GET', $url);

         $this->assertEquals(302, $client->getResponse()->getStatusCode());

    }

    public function urlProviderAdminGetSuccessful()
    {
        yield ['/admin'];
        yield ['/backoffice/'];
        yield ['/backoffice/place/category/browse'];
        yield ['/backoffice/place/category/add'];
        yield ['/backoffice/place/category/read/1'];
        yield ['/backoffice/place/category/edit/1'];
        yield ['/backoffice/place/browse'];
        yield ['/backoffice/place/add'];
        yield ['/backoffice/place/read/1'];
        yield ['/backoffice/place/edit/1'];
    }

}