<?php

namespace App\EventSubscriber;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

  class EasyAdminSubscriber implements EventSubscriberInterface
  {

      private $entityManager;
      private $passwordEncoder;

      public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
      {
          $this->entityManager = $entityManager;
          $this->passwordEncoder = $passwordEncoder;
      }

      public static function getSubscribedEvents()
      {
          return [
              BeforeEntityPersistedEvent::class => ['addUser'],
              BeforeEntityUpdatedEvent::class => ['updateUser'],
              BeforeEntityUpdatedEvent::class => ['updateProduct'],
            ];
      }

      //verifies that the event is for the User entity
      //if so, call the method for encrypting the password
      public function updateUser(BeforeEntityUpdatedEvent $event)
      {
          $entity = $event->getEntityInstance();

          if (!($entity instanceof User)) {

              return;
          }
          $this->setPassword($entity);
      }

      //verifies that the event is for the User entity
      //if so, call the method for encrypting the password
      public function addUser(BeforeEntityPersistedEvent $event)
      {
          $entity = $event->getEntityInstance();

          if (!($entity instanceof User)) {
              return;
          }
          $this->setPassword($entity);
      }

      /**
       * @param User $entity
       */
      public function setPassword(User $entity): void
      {
          //retrieves the password of the current User object
          $pass = $entity->getPassword();

          //password encryption
          $entity->setPassword(
              $this->passwordEncoder->encodePassword(
                  $entity,
                  $pass
              )
          );

          //save the datas
          $this->entityManager->persist($entity);
          $this->entityManager->flush();
      }

      //verifies that the event is for the Product entity
      //if so, call the method setProductCategory and setProductImage
      public function updateProduct(BeforeEntityUpdatedEvent $event)
      {
            $entity = $event->getEntityInstance();

            if (!($entity instanceof Product)) {
                return;
            }
            $this->setProductCategory($entity);
            $this->setProductImage($entity);


      }

      /**
       * adds the category Tendance to Product if the administrator chooses it in the backOffice
       *
       * @param Product $entity
       * @return void
       */
      public function setProductCategory(Product $entity)
      {
            //retrieves the boolean from the product class that determines whether the product has the Tendance 
            //category
            $tendanceBoolean = $entity->getTendanceBoolean();

            //retrieves the categories associated with the product
            $productCategories = $entity->getProductCategories();

            //saves the productcategory object in a variable if its name is not tendance
            foreach ($productCategories as $productCategory) {

                if (false === str_contains($productCategory->getName(), 'endance')) {

                    $productCategoryWithoutTendance = $productCategory;

                }
            }

            //If tendanceBoolean is true, we will search the Tendance category
            //the Tendance category and the current category are added to the current Product
            if ($tendanceBoolean) {
                $qb = $this->entityManager->createQueryBuilder();
                $productCategorytendance = $qb
                ->select('pc')
                ->from('App\Entity\ProductCategory', 'pc')
                ->where("pc.name LIKE '%endance%'")
                ->getQuery()
                ->getSingleResult();

                $entity->addProductCategory($productCategorytendance);

                $entity->addProductCategory($productCategoryWithoutTendance);

            //if the tendanceBoolean is false, only the current category is added
            }elseif (!$tendanceBoolean) {

                $entity->addProductCategory($productCategoryWithoutTendance);
            }

                $this->entityManager->persist($entity);
                $this->entityManager->flush();

      }

      /**
       * If no image associated with Product, add a default image
       *
       * @param Product $entity
       * @return void
       */
      public function setProductImage(Product $entity)
      {

        //retrieves the product id
        $productId = $entity->getId();

        //Checks if a product is associated with the image
        $qb = $this->entityManager->createQueryBuilder();
                $image = $qb
                ->select('i')
                ->from('App\Entity\Image', 'i')
                ->where("i.product = :id")
                ->setParameter('id', $productId)
                ->getQuery()
                ->getResult();

        //If no image, build a default image and associate with Product
        if (empty($image)) {
            $image = new Image();
            $image->setProduct($entity);
            $image->setName('default-image');
            $image->setDisplayOrder(0);
            $this->entityManager->persist($image);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

      }

  }