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

    public function testAddRecord()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/add-new-record');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['food[username]'] = 'John Doe';
        $form['food[entitled]'] = 'Plat de pâtes';
        $form['food[calories]'] = 600;
        $crawler = $client->submit($form);

        $crawler = $client->followRedirect(); // Attention  à bien récupérer le crawler mis à jour

//        echo $client->getResponse()->getContent();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testAddRecordEmptyField()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/add-new-record');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['food[username]'] = 'John Doe';
        $form['food[entitled]'] = null;
        $form['food[calories]'] = null;
        $crawler = $client->submit($form);

//        $client->followRedirect(); // Attention  à bien récupérer le crawler mis à jour

//        echo $client->getResponse()->getContent();
//        var_dump($crawler->filter('div.has-error'));
        $this->assertSame(2, $crawler->filter('div.has-error')->count());
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Voir tous les rapports')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); // On retire les retours à la ligne pour faciliter la vérification

//        echo $client->getResponse()->getContent();
//        echo $info;

        $this->assertSame("Tous les rapports Tout ce qui a été mangé !", $info);
    }

}