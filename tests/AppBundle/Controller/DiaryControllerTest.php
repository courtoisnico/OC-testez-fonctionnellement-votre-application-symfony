<?php
/**
 * Created by PhpStorm.
 * User: ncourtois
 * Date: 31/08/2018
 * Time: 16:58
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiaryControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

//        echo $client->getResponse()->getContent();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testHomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur FoodDiary !")')->count());
    }

}