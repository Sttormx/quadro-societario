<?php
namespace App\Modules\Partners\Repository;

use App\Modules\Partners\Entity\Partner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partner::class);
    }

    public function Create(string $name, string $document): Partner
    {
        $entityManager = $this->getEntityManager();
        $partner = new Partner();
        $partner->setUuid(Uuid::v7()->generate());
        $partner->setName($name);
        $partner->setDocument($document);
        $partner->setCreatedAt(new \DateTimeImmutable());
        
        $entityManager->persist($partner);
        $entityManager->flush();

        return $partner;
    }

    public function FindByDocument(string $document): ?Partner
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\Partners\Entity\Partner c WHERE c.document = :document AND c.deleted_at IS NULL'
        )->setParameter('document', $document);

        return $query->getOneOrNullResult();
    }

    public function FindByUuid(string $uuid): ?Partner
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\Partners\Entity\Partner c WHERE c.uuid = :uuid AND c.deleted_at IS NULL'
        )->setParameter('uuid', $uuid);

        return $query->getOneOrNullResult();
    }

    public function FindAllActive(): array {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\Partners\Entity\Partner c WHERE c.deleted_at IS NULL'
        );

        return $query->getResult();
    }

    public function Update(Partner $partner, array $updatedData): Partner
    {
        $entityManager = $this->getEntityManager();

        if (isset($updatedData['name'])) {
            $partner->setName($updatedData['name']);
        }
        if (isset($updatedData['document'])) {
            $partner->setDocument($updatedData['document']);
        }

        $partner->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($partner);
        $entityManager->flush();

        return $partner;
    }

    public function SoftDelete(partner $partner): partner
    {
        $entityManager = $this->getEntityManager();
        
        $partner->setDeletedAt(new \DateTime());
        $entityManager->persist($partner);
        $entityManager->flush();

        return $partner;
    }
}
