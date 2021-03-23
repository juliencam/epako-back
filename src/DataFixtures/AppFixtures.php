<?php

namespace App\DataFixtures;

use Faker\Factory ;
use App\Entity\ProductCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    const NB_PRODUCT_SUBCATEGORY = 30;

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        // Toujours les mêmes données
        $faker->seed(2021);

        // Un tableau pour stocker nos product Category pour pouvoir les stocker dans product
        $productCategoryList = [];

        /**
         * créer sous categorie
         * déterminer qui est parent des sous categories en piochant dans les sous categories
         * la sous categorie devient categorie
         * définir par tranche de 5 l'attribution de la catégorie mère
         */

        for ($i = 1; $i <= self::NB_PRODUCT_SUBCATEGORY; $i++) {
            // Un genre
            $productCategory = new ProductCategory();
            // Modifier unique() de faker
            // @see https://fakerphp.github.io/#modifiers
            $productCategory->setName($faker->unique()->word());
            //$productCategory->setPictogram($faker->unique()->imageUrl(40, 40, 'animals', true, 'cats'));

            $productCategoryList[] = $productCategory;

            if ($i === 1) {
                $productCategory->setPictogram('yo soy picto');
            }

            if ($i > 1 && $i < 6 ) {
                $productCategory->setParent($productCategoryList[0]);
            }

            if ($i === 6) {
                $productCategory->setPictogram('yo soy picto');
            }

            if ($i > 6 && $i < 11) {
                $productCategory->setParent($productCategoryList[5]);
            }

            if ($i === 11) {
                $productCategory->setPictogram('yo soy picto');
            }

            if ($i > 11 && $i < 16) {
                $productCategory->setParent($productCategoryList[10]);
            }

            if ($i === 16) {
                $productCategory->setPictogram('yo soy picto');
            }

            if ($i > 16 && $i < 21) {
                $productCategory->setParent($productCategoryList[15]);
            }

            if ($i === 21) {
                $productCategory->setPictogram('yo soy picto');
            }

            if ($i > 21 && $i < 26) {
                $productCategory->setParent($productCategoryList[20]);
            }

            if ($i === 26) {
                $productCategory->setPictogram('yo soy picto');
            }

            if ($i > 26 && $i < 31) {
                $productCategory->setParent($productCategoryList[25]);
            }

            $manager->persist($productCategory);
        }

        $manager->flush();
    }
}
