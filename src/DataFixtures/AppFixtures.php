<?php

namespace App\DataFixtures;

use Faker\Factory ;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductCategory;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    const NB_PRODUCT_SUBCATEGORY = 30;
    const NB_PRODUCT = 50;
    const NB_IMAGE = 50;

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
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


        $productList = [];
        for ($i = 1; $i <= self::NB_PRODUCT; $i++) {

            $product = new Product();
            // Modifier unique() de faker
            // @see https://fakerphp.github.io/#modifiers
            $product->setName($faker->word());
            $product->setContent($faker->sentence(20));
            $product->setPrice($faker->randomNumber(2));
            $product->setStatus(0);
            $product->setBrand($faker->word());

            $productList[] = $product;

            $manager->persist($product);
        }

        $imageList = [];
        for ($i = 1; $i <= self::NB_IMAGE; $i++) {

            $image = new Image();
            // Modifier unique() de faker
            // @see https://fakerphp.github.io/#modifiers

            $image->setProduct($productList[$i-1]);
            $image->setAlt($faker->sentence(8));
            $image->setUrl($faker->imageUrl(200, 200));
            $image->setDisplayOrder(0);

            $imageList[] = $image;

            $manager->persist($image);
        }

        $manager->flush();
    }
}
