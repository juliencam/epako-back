<?php

namespace App\DataFixtures;

use Faker\Factory ;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Department;
use Doctrine\DBAL\Connection;
use App\Entity\ProductCategory;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\EpakoProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    const NB_PRODUCT_SUBCATEGORY = 26;
    const NB_PRODUCT = 50;
    const NB_IMAGE = 50;

    // Password encoder
    private $passwordEncoder;

    // Connection à MySQL (DBAL => PDO)
    private $connection;

    /**
     * On injecte les dépendances (les objets utiles au fonctionnement de nos Fixtures) dans le constructeur car AppFixtures est elle aussi un service
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Connection $connection)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->connection = $connection;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $faker->addProvider(new EpakoProvider($faker));
        // Toujours les mêmes données
        $faker->seed(2021);

        // MANAGER
        $userManager = new User();
        $userManager->setEmail('manager@manager.com');
        $userManager->setRoles(['ROLE_MANAGER']);
        $encodedPassword = $this->passwordEncoder->encodePassword($userManager, 'manager');
        $userManager->setPassword($encodedPassword);
        $userManager->setNickname('manager');
        $userManager->setStatus(0);
        // manager
        // On encode le mot de passe avec le service qui va bien

        $manager->persist($userManager);

        // ADMIN
        $adminManager = new User();
        $adminManager->setEmail('admin@admin.com');
        $adminManager->setRoles(['ROLE_ADMIN']);
                // admin
        // On encode le mot de passe avec le service qui va bien
        $encodedPassword = $this->passwordEncoder->encodePassword($adminManager, 'admin');
        $adminManager->setPassword($encodedPassword);
        $adminManager->setNickname('admin');
        $adminManager->setStatus(0);
        
        $manager->persist($adminManager);

        // Un tableau pour stocker nos product Category pour pouvoir les stocker dans product
        $productCategoryList = [];
        $finalProductCategoryList = [];
        $productCategoryParent  = [];
        $productCategoryChild  = [];

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
                $productCategoryParent[] = $productCategory;
            }

            if ($i > 1 && $i < 6 ) {
                $productCategory->setParent($productCategoryList[0]);
                $productCategoryChild[] = $productCategory;
            }

            if ($i === 6) {
                $productCategory->setPictogram('yo soy picto');
                $productCategoryParent[] = $productCategory;
            }

            if ($i > 6 && $i < 11) {
                $productCategory->setParent($productCategoryList[5]);
                $productCategoryChild[] = $productCategory;
            }

            if ($i === 11) {
                $productCategory->setPictogram('yo soy picto');
                $productCategoryParent[] = $productCategory;
            }

            if ($i > 11 && $i < 16) {
                $productCategory->setParent($productCategoryList[10]);
                $productCategoryChild[] = $productCategory;
            }

            if ($i === 16) {
                $productCategory->setPictogram('yo soy picto');
                $productCategoryParent[] = $productCategory;
            }

            if ($i > 16 && $i < 21) {
                $productCategory->setParent($productCategoryList[15]);
                $productCategoryChild[] = $productCategory;
            }

            if ($i === 21) {
                $productCategory->setPictogram('yo soy picto');
                $productCategoryParent[] = $productCategory;
            }

            if ($i > 21 && $i < 26) {
                $productCategory->setParent($productCategoryList[20]);
                $productCategoryChild[] = $productCategory;
            }

            if ($i === 26) {
                $productCategory->setPictogram('yo soy picto');
                $productCategory->setName('tendance');
                $productCategoryParent[] = $productCategory;
            }


            $finalProductCategoryList[] = $productCategory;

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

            if ($i < 10) {
                $product->addProductCategory($finalProductCategoryList[25]);

            }
                $product->addProductCategory($productCategoryChild[mt_rand(0,19)]);
                $product->addProductCategory($productCategoryChild[mt_rand(0,19)]);


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

        $departmentList = [];

        foreach ($faker->getDepartment() as $postalcode => $departmentName) {

            $departmentEntity = new Department();

            $departmentEntity->setName($departmentName);
            $departmentEntity->setPostalcode($postalcode);

            $departmentList[] = $departmentEntity;

            $manager->persist($departmentEntity);
        }



        $manager->flush();
    }
}
