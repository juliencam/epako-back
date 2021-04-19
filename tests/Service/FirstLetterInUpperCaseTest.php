<?php

namespace App\Tests\Service;

use App\Service\FirstLetterInUpperCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FirstLetterInUpperCaseTest extends KernelTestCase
{
    public function testChangeFirstLetterInUpperCase(): void
    {
        //The FirstLetterInUpperCase service is retrieved from the container
        self::bootKernel();
        $container = self::$container;
        $firstLetterInUpperCase = $container->get(FirstLetterInUpperCase::class);

        //changes the boolean value of the environment variable so that
        //the FirstLetterInUpperCase service changes the first letter to upper case.
        $firstLetterInUpperCase->setFirstLetterInUpperCase(true);

        //changes the first letter to uppercase
        $wordTest = $firstLetterInUpperCase->changeFirstLetter('test');

        //Check that the expected behaviour is correct
        $this->assertEquals('Test', $wordTest);
    }

    public function testNotToChangeFirstLetterInUpperCase(): void
    {
        //The FirstLetterInUpperCase service is retrieved from the container
        self::bootKernel();
        $container = self::$container;
        $firstLetterInUpperCase = $container->get(FirstLetterInUpperCase::class);

        //changes the Boolean value of the environment variable so that the FirstLetterInUpperCase
        //service does not change the first letter to upper case.
        $firstLetterInUpperCase->setFirstLetterInUpperCase(false);

        //don't changes the first letter to uppercase
        $wordTest = $firstLetterInUpperCase->changeFirstLetter('test');

        // Check that the expected behaviour is correct
        $this->assertEquals('test', $wordTest);
    }

}
