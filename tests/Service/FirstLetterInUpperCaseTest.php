<?php

namespace App\Tests\Service;

use App\Service\FirstLetterInUpperCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Si on on veut où que l'on doit(ve) passer par le conteneur de services
 */
class FirstLetterInUpperCaseTest extends KernelTestCase
{
    public function testChangeFirstLetterInUpperCase(): void
    {
        // On veut accéder au conteneur de services depuis le Kernel
        // (plutôt que de passer notre service en public dans services.yaml)
        self::bootKernel();
        $container = self::$container;
        // On récupère notre service depuis le conteneur
        $firstLetterInUpperCase = $container->get(FirstLetterInUpperCase::class);

        $firstLetterInUpperCase->setFirstLetterInUpperCase(true);

        $wordTest = $firstLetterInUpperCase->changeFirstLetter('test');

        // Vérifier qu'elle est correcte
        $this->assertEquals('Test', $wordTest);
    }

    public function testNotToChangeFirstLetterInUpperCase(): void
    {
        // On veut accéder au conteneur de services depuis le Kernel
        // (plutôt que de passer notre service en public dans services.yaml)
        self::bootKernel();
        $container = self::$container;
        // On récupère notre service depuis le conteneur
        $firstLetterInUpperCase = $container->get(FirstLetterInUpperCase::class);

        $firstLetterInUpperCase->setFirstLetterInUpperCase(false);


        $wordTest = $firstLetterInUpperCase->changeFirstLetter('test');

        // Vérifier qu'elle est correcte
        $this->assertEquals('test', $wordTest);
    }

}
