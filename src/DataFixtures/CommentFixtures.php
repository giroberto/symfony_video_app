<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->commentData() as [$content, $user, $video, $created_at]) {
            $comment = new Comment();
            $user = $manager->getRepository(User::class)->find($user);
            $video = $manager->getRepository(Video::class)->find($video);

            $comment->setContent($content);
            $comment->setUser($user);
            $comment->setVideo($video);
            $comment->setCreatedAtForFixtures(new \DateTime($created_at));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function commentData()
    {
        return [
            ['comment text1', 1, 10, '2018-10-08 12:34:45'],
            ['comment text2', 2, 10, '2018-10-08 12:34:45'],
            ['comment text3', 1, 11, '2018-10-08 12:34:45'],
            ['comment text4', 2, 11, '2018-10-08 12:34:45'],
            ['comment text5', 3, 11, '2018-10-08 21:34:45'],
            ['comment text6', 3, 11, '2018-10-08 22:34:45'],
            ['comment text7', 3, 11, '2018-10-08 23:34:45'],
        ];
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
