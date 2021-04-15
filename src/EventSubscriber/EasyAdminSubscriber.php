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
              BeforeEntityUpdatedEvent::class => ['updateUser'], //surtout utile lors d'un reset de mot passe plutôt qu'un réel update, car l'update va de nouveau encrypter le mot de passe DEJA encrypté ...
              BeforeEntityUpdatedEvent::class => ['updateProduct'],
            ];
      }

      public function updateUser(BeforeEntityUpdatedEvent $event)
      {
          $entity = $event->getEntityInstance();

          if (!($entity instanceof User)) {
              return;
          }
          $this->setPassword($entity);
      }

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
          $pass = $entity->getPassword();

          $entity->setPassword(
              $this->passwordEncoder->encodePassword(
                  $entity,
                  $pass
              )
          );
          $this->entityManager->persist($entity);
          $this->entityManager->flush();
      }


      public function updateProduct(BeforeEntityUpdatedEvent $event)
      {
            $entity = $event->getEntityInstance();

            if (!($entity instanceof Product)) {
                return;
            }
            $this->setProductCategory($entity);
            $this->setProductImage($entity);


      }

      public function setProductCategory(Product $entity)
      {
            //récupère le boolean de la classe product qui détermine si le produit a la catégorie tendance
            $tendanceBoolean = $entity->getTendanceBoolean();

            //récupère les catégories associés au produit
            $productCategories = $entity->getProductCategories();

            //sauvegarde dans une variable l'objet productcategory si son name n'est pas tendance
            foreach ($productCategories as $productCategory) {

                if (false === str_contains($productCategory->getName(), 'endance')) {

                    $productCategoryWithoutTendance = $productCategory;

                }
            }

            //si tendanceBoolean vaut true, on va chercher la catégorie Tendance
            //on ajoute au product courant la catégorie tendance et la catégorie courante
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

            // si le tendancboolean caut false on ne rajoute que la catégorie courante
            }elseif (!$tendanceBoolean) {

                $entity->addProductCategory($productCategoryWithoutTendance);
            }

                $this->entityManager->persist($entity);
                $this->entityManager->flush();

      }

      public function setProductImage(Product $entity)
      {

        //récupère l'id de product
        $productId = $entity->getId();

        //Vérifie su un product est associé à l'image
        $qb = $this->entityManager->createQueryBuilder();
                $image = $qb
                ->select('i')
                ->from('App\Entity\Image', 'i')
                ->where("i.product = :id")
                ->setParameter('id', $productId)
                ->getQuery()
                ->getResult();

        //Si pas d'image construction d'une image par défaut et association à Product
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