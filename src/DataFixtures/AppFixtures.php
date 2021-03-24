<?php

namespace App\DataFixtures;

use Faker\Factory ;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Place;
use App\Entity\Review;
use App\Entity\Product;
use App\Entity\Department;
use App\Entity\PlaceCategory;
use Doctrine\DBAL\Connection;
use Ottaviano\Faker\Gravatar;
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
    const NB_PLACE_CATEGORY = 6;
    const NB_PLACE = 30;
    const NB_REVIEW = 60;

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

    private function truncate()
    {
        // On passen mode SQL ! On cause avec MySQL
        // Désactivation des contraintes FK
        $users = $this->connection->query('SET foreign_key_checks = 0');
        // On tronque
        $users = $this->connection->query('TRUNCATE TABLE department');
        $users = $this->connection->query('TRUNCATE TABLE image');
        $users = $this->connection->query('TRUNCATE TABLE place');
        $users = $this->connection->query('TRUNCATE TABLE place_category');
        $users = $this->connection->query('TRUNCATE TABLE product');
        $users = $this->connection->query('TRUNCATE TABLE product_category');
        $users = $this->connection->query('TRUNCATE TABLE product_category_place');
        $users = $this->connection->query('TRUNCATE TABLE product_product_category');
        $users = $this->connection->query('TRUNCATE TABLE review');
        $users = $this->connection->query('TRUNCATE TABLE user');
        // etc.
    }

    public function load(ObjectManager $manager)
    {
        // On va truncate nos tables à la main pour revenir à id=1
        $this->truncate();
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $faker->addProvider(new EpakoProvider($faker));
        $faker->addProvider(new Gravatar($faker));
        // Toujours les mêmes données
        $faker->seed(2021);


        //USER
        //user avec role par defaut ROLE_USER
        $tabUserReviewList = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->email());
            $user->setRoles(['ROLE_USER']);
            $encodedPassword = $this->passwordEncoder->encodePassword($user, 'user');
            $user->setPassword($encodedPassword);
            $user->setNickname($faker->firstName());
            $user->setStatus(0);

            $tabUserReviewList[] = $user;

            $manager->persist($user);

        }

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

        $placeCategoryList = [];
        for ($i = 1; $i <= self::NB_PLACE_CATEGORY; $i++) {

            $placeCategory = new PlaceCategory();
            // Modifier unique() de faker
            // @see https://fakerphp.github.io/#modifiers

            $placeCategory->setName($faker->unique()->company());
            $placeCategory->setPictogram('picto de la plaça');

            $placeCategoryList[] = $placeCategory;

            $manager->persist($placeCategory);
        }

        $placeList = [];
        for ($i = 1; $i <= self::NB_PLACE; $i++) {

            $place = new Place();

            $place->setName($faker->unique()->company());
            $place->setAddress($faker->streetAddress());
            $place->setAddressComplement($faker->secondaryAddress());
            $place->setCity($faker->city());
            $place->setLogo($faker->gravatarUrl());
            $place->setStatus(0);
            $place->setUrl('https://www.youtube.com/watch?v=LEYJ4VsCy7o&ab_channel=Onision');

            $randomDepartment = $departmentList[mt_rand(0, count($departmentList)-1)];
            $place->setDepartment($randomDepartment);

            $randomPlaceCategory = $placeCategoryList[mt_rand(0, count($placeCategoryList)-1)];
            $place->setPlaceCategory($randomPlaceCategory);

            $placeList[] = $place;

            $manager->persist($place);
        }

        $reviewList = [];
        for ($i = 1; $i <= self::NB_REVIEW; $i++) {

            $review = new Review();

            $review->setContent($faker->sentence(20));
            $review->setRate(mt_rand(1,5));
            $review->setStatus(0);

            $randomUserReview = $tabUserReviewList[mt_rand(0, count($tabUserReviewList)-1)];
            $review->setUser($randomUserReview);

            shuffle($placeList);
            for ($r = 0; $r < mt_rand(1, 3); $r++) {
                $randomPlace = $placeList[$r];
                $review->setPlace($randomPlace);
            }

            $reviewList[] = $review;

            $manager->persist($review);
        }

        $manager->flush();
    }
}
