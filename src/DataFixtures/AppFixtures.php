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

    const NB_PRODUCT_CATEGORY = 26;
    const NB_PRODUCT = 50;
    const NB_IMAGE = 50;
    const NB_PLACE_CATEGORY = 6;
    const NB_PLACE = 30;
    const NB_REVIEW = 60;

    /**
     * UserPasswordEncoderInterface is the interface for the password encoder service.
     *
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * Connection service for MySQL
     *
     * @var Connection
     */
    private $connection;

    /**
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Connection $connection
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Connection $connection)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->connection = $connection;
    }

    /**
     * reset to zero of ID
     *
     * @return void
     */
    private function truncate()
    {
        // Disabling foreign_key constraints
        $this->connection->query('SET foreign_key_checks = 0');
        $this->connection->query('TRUNCATE TABLE department');
        $this->connection->query('TRUNCATE TABLE image');
        $this->connection->query('TRUNCATE TABLE place');
        $this->connection->query('TRUNCATE TABLE place_category');
        $this->connection->query('TRUNCATE TABLE product');
        $this->connection->query('TRUNCATE TABLE product_category');
        $this->connection->query('TRUNCATE TABLE product_category_place');
        $this->connection->query('TRUNCATE TABLE product_product_category');
        $this->connection->query('TRUNCATE TABLE review');
        $this->connection->query('TRUNCATE TABLE user');
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $this->truncate();

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        // Custom provider
        $faker->addProvider(new EpakoProvider($faker));
        $faker->addProvider(new Gravatar($faker));

        // allows to generate always the same data
        $faker->seed(2021);

        //?______________________________USER___________________________________

        //table that stores the users
        $tabUserReviewList = [];

        //creation of ten users with the role user and the password user by default
        for ($i = 1; $i <= 10; $i++) {

            $user = new User();

            // unique() allows the field to be unique
            // @see https://fakerphp.github.io/#modifiers
            $user->setEmail($faker->unique()->email());
            $user->setRoles(['ROLE_USER']);
            $encodedPassword = $this->passwordEncoder->encodePassword($user, 'user');
            $user->setPassword($encodedPassword);
            $user->setNickname($faker->firstName());
            $user->setStatus(0);

            $tabUserReviewList[] = $user;

            $manager->persist($user);

        }

        //? MANAGER
        $userManager = new User();
        $userManager->setEmail('manager@manager.com');
        $userManager->setRoles(['ROLE_MANAGER']);
        $encodedPassword = $this->passwordEncoder->encodePassword($userManager, 'manager');
        $userManager->setPassword($encodedPassword);
        $userManager->setNickname('manager');
        $userManager->setStatus(0);

        $manager->persist($userManager);

        //? ADMIN
        $adminManager = new User();
        $adminManager->setEmail('admin@admin.com');
        $adminManager->setRoles(['ROLE_ADMIN']);
        $encodedPassword = $this->passwordEncoder->encodePassword($adminManager, 'admin');
        $adminManager->setPassword($encodedPassword);
        $adminManager->setNickname('admin');
        $adminManager->setStatus(0);

        $manager->persist($adminManager);

        //stores all ProductCategory objects
        $productCategoryList = [];

        //stores all ProductCategory objects after modification
        $finalProductCategoryList = [];

        //stores the parent ProductCategory
        $productCategoryParentList = [];

        //stores the children ProductCategory
        $productCategoryChildList  = [];

        /**
         * create productcategory
         * determine a parent
         * determine 4 subcategories to the parent
         * lastly, determine the tendance category
         */
        for ($i = 1; $i <= self::NB_PRODUCT_CATEGORY; $i++) {

            $productCategory = new ProductCategory();

            $productCategory->setName($faker->unique()->word());

            $productCategoryList[] = $productCategory;

            if ($i === 1) {
                $productCategory->setPictogram('');
                $productCategoryParentList[] = $productCategory;
            }

            if ($i > 1 && $i < 6 ) {
                $productCategory->setParent($productCategoryList[0]);
                $productCategory->setPictogram('picto');
                $productCategoryChildList[] = $productCategory;
            }

            if ($i === 6) {
                $productCategory->setPictogram('');
                $productCategoryParentList[] = $productCategory;
            }

            if ($i > 6 && $i < 11) {
                $productCategory->setParent($productCategoryList[5]);
                $productCategory->setPictogram('picto');
                $productCategoryChildList[] = $productCategory;
            }

            if ($i === 11) {
                $productCategory->setPictogram('');
                $productCategoryParentList[] = $productCategory;
            }

            if ($i > 11 && $i < 16) {
                $productCategory->setParent($productCategoryList[10]);
                $productCategory->setPictogram('picto');
                $productCategoryChildList[] = $productCategory;
            }

            if ($i === 16) {
                $productCategory->setPictogram('');
                $productCategoryParentList[] = $productCategory;
            }

            if ($i > 16 && $i < 21) {
                $productCategory->setParent($productCategoryList[15]);
                $productCategory->setPictogram('picto');
                $productCategoryChildList[] = $productCategory;
            }

            if ($i === 21) {
                $productCategory->setPictogram('');
                $productCategoryParentList[] = $productCategory;
            }

            if ($i > 21 && $i < 26) {
                $productCategory->setParent($productCategoryList[20]);
                $productCategory->setPictogram('picto');
                $productCategoryChildList[] = $productCategory;
            }

            if ($i === 26) {
                $productCategory->setPictogram('');
                $productCategory->setName('tendance');
                $productCategoryParentList[] = $productCategory;
            }


            $finalProductCategoryList[] = $productCategory;

            $manager->persist($productCategory);

        }

        //store the Product
        $productList = [];
        for ($i = 1; $i <= self::NB_PRODUCT; $i++) {

            $product = new Product();
            $product->setName($faker->word());
            $product->setContent($faker->sentence(20));
            $product->setPrice($faker->randomNumber(2));
            $product->setStatus(0);
            $product->setBrand($faker->word());

            //the top ten products in the tendance category
            if ($i < 10) {
                $product->addProductCategory($finalProductCategoryList[25]);

            }
                //association of sub-categories to the product
                $product->addProductCategory($productCategoryChildList[mt_rand(0,19)]);

                $productList[] = $product;

                $manager->persist($product);
        }

        //store the Image
        $imageList = [];

        for ($i = 1; $i <= self::NB_IMAGE; $i++) {

            $image = new Image();

            //association of images to the products
            $image->setProduct($productList[$i-1]);
            $image->setAlt($faker->sentence(8));
            $image->setUrl($faker->imageUrl(400, 400, true));
            $image->setDisplayOrder(0);

            $imageList[] = $image;

            $manager->persist($image);
        }

        //store the department
        $departmentList = [];

        //use of custom provider for department
        foreach ($faker->getDepartment() as $postalcode => $departmentName) {

            $departmentEntity = new Department();

            $departmentEntity->setName($departmentName);
            $departmentEntity->setPostalcode($postalcode);

            $departmentList[] = $departmentEntity;

            $manager->persist($departmentEntity);
        }

        //store the PlaceCategory
        $placeCategoryList = [];
        for ($i = 1; $i <= self::NB_PLACE_CATEGORY; $i++) {

            $placeCategory = new PlaceCategory();

            $placeCategory->setName($faker->unique()->company());

            $placeCategory->setPictogram('picto of the place');

            $placeCategoryList[] = $placeCategory;

            $manager->persist($placeCategory);
        }

        //store the Place
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

            //find a department at random
            $randomDepartment = $departmentList[mt_rand(0, count($departmentList)-1)];

            //association of department to the place
            $place->setDepartment($randomDepartment);

            //find a placecategory at random
            $randomPlaceCategory = $placeCategoryList[mt_rand(0, count($placeCategoryList)-1)];

            //association of placecategory to the place
            $place->setPlaceCategory($randomPlaceCategory);

            //association between one and three sub-category at random
            shuffle($productCategoryChildList);
            for ($r = 0; $r < mt_rand(1, 3); $r++) {
                $randomCategoryChild = $productCategoryChildList[$r];
                $place->addProductCategory($randomCategoryChild);
            }

            $placeList[] = $place;

            $manager->persist($place);
        }

        //store the Review
        $reviewList = [];
        for ($i = 1; $i <= self::NB_REVIEW; $i++) {

            $review = new Review();

            $review->setContent($faker->sentence(20));
            $review->setRate(mt_rand(1,5));
            $review->setStatus(0);

            //association of user to the review at random
            $randomUserReview = $tabUserReviewList[mt_rand(0, count($tabUserReviewList)-1)];
            $review->setUser($randomUserReview);

            //association between one and three place to the review at random
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
