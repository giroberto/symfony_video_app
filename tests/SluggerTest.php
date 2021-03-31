<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Twig\AppExtension;

class SluggerTest extends TestCase
{
    /**
     * @dataProvider getData
     */
    public function testSlugify(string $string, string $slug): void
    {
        $slugger = new AppExtension;
        $this->assertSame($slug, $slugger->slugify($string));
    }

    public function getData(){
        yield ['Spaced Data', 'spaced-data'];
        yield [' Not Trimmed Spaced Data ', 'not-trimmed-spaced-data'];
        yield ['Spaced Data with Plus+', 'spaced-data-with-plus'];
    }
}
