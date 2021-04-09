<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture
{

    /**
     * @dataProvider VideoData
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->VideoData() as [$title, $path, $category_id]) {
            $duration = random_int(10, 300);
            $category = $manager->getRepository(Category::class)->find($category_id);
            $video = new Video();
            $video->setTitle($title);
            $video->setPath('https://player.vimeo.com/video/' . $path);
            $video->setCategory($category);
            $video->setDuration($duration);
            $manager->persist($video);
        }
        $manager->flush();

        $this->likedVideos($manager);
        $this->dislikedVideos($manager);
    }

    public function likedVideos($manager)
    {
        foreach ($this->likesData() as [$video, $user]) {
            $video = $manager->getRepository(Video::class)->find($video);
            $user = $manager->getRepository(User::class)->find($user);
            $video->addUsersThatLike($user);
            $manager->persist($video);
        }
        $manager->flush();
    }

    public function dislikedVideos($manager)
    {
        foreach ($this->dislikesData() as [$video, $user]) {
            $video = $manager->getRepository(Video::class)->find($video);
            $user = $manager->getRepository(User::class)->find($user);
            $video->addUsersThatLike($user);
            $manager->persist($video);
        }
        $manager->flush();
    }

    private function VideoData(): array
    {
        return [
            ['Movies 1', 289729765, 4],
            ['Movies 2', 238902809, 4],
            ['Movies 3', 150870038, 4],
            ['Movies 4', 219727723, 4],
            ['Movies 5', 289879647, 4],
            ['Movies 6', 261379936, 4],
            ['Movies 7', 289029793, 4],
            ['Movies 8', 60594348, 4],
            ['Movies 9', 290253648, 4],

            ['Family 1', 289729765, 10],
            ['Family 2', 289729765, 10],
            ['Family 3', 289729765, 10],

            ['Romantic comedy 1', 289729765, 11],
            ['Romantic comedy 2', 289729765, 11],

            ['Romantic drama 1', 289729765, 11],

            ['Toys  1', 289729765, 2],
            ['Toys  2', 289729765, 2],
            ['Toys  3', 289729765, 2],
            ['Toys  4', 289729765, 2],
            ['Toys  5', 289729765, 2],
            ['Toys  6', 289729765, 2]
        ];
    }

    public function likesData(): array
    {
        return [
            [12, 1], [12, 2], [12, 3],
            [11, 1], [11, 2],
            [1, 1], [1, 2], [1, 3],
            [2, 1], [2, 2]
        ];
    }

    public function dislikesData(): array
    {
        return [
            [10, 1], [10, 2], [10, 3]
        ];
    }
}
