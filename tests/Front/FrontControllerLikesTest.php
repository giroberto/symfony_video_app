<?php

namespace App\Tests\Front;

use App\Tests\RoleUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerLikesTest extends WebTestCase
{
    use RoleUser;
    public function testLike()
    {
        $this->client->request('POST', '/video-list/3/like');
        $crawler = $this->client->request('GET', '/video-list/category/movies,4');
        $this->assertSame('(1)', $crawler->filter('small.number-of-likes-3')->text());
    }

    public function testDislike()
    {
        $this->client->request('POST', '/video-list/3/dislike');
        $crawler = $this->client->request('GET', '/video-list/category/movies,4');
        $this->assertSame('(1)', $crawler->filter('small.number-of-dislikes-3')->text());
    }

    public function testListOfLikedVideos(){
        $this->client->request('POST', '/video-list/3/like');
        $crawler = $this->client->request('GET', '/admin/videos');
        $this->assertSame(8, $crawler->filter('tr')->count());
    }

    public function testNumberOfLikedVideos(){
        $this->client->request('POST', '/video-list/3/like');
        $this->client->request('POST', '/video-list/3/like');

        $crawler = $this->client->request('GET', '/admin/videos');
        $this->assertSame(8, $crawler->filter('tr')->count());
    }

    public function testNumberOfLikedVideosAfterUnlikes(){
        $this->client->request('POST', '/video-list/1/undo-like');
        $this->client->request('POST', '/video-list/2/undo-like');

        $crawler = $this->client->request('GET', '/admin/videos');
        $this->assertSame(5, $crawler->filter('tr')->count());
    }
}
