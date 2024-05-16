<?php
namespace App\Modules\Companies\Repository;

use App\Modules\Companies\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function Create(string $name, string $document): Company
    {
        $entityManager = $this->getEntityManager();
        $company = new Company();
        $company->setUuid(Uuid::v7()->generate());
        $company->setName($name);
        $company->setDocument($document);
        $company->setCreatedAt(new \DateTimeImmutable());
        
        $entityManager->persist($company);
        $entityManager->flush();

        return $company;
    }

    public function FindByDocument(string $document): ?Company
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\Companies\Entity\Company c WHERE c.document = :document AND c.deleted_at IS NULL'
        )->setParameter('document', $document);

        return $query->getOneOrNullResult();
    }

    public function FindByUuid(string $uuid): ?Company
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\Companies\Entity\Company c WHERE c.uuid = :uuid AND c.deleted_at IS NULL'
        )->setParameter('uuid', $uuid);

        return $query->getOneOrNullResult();
    }

    public function FindAllActive(): array {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\Companies\Entity\Company c WHERE c.deleted_at IS NULL'
        );

        return $query->getResult();
    }

    public function Update(Company $company, array $updatedData): Company
    {
        $entityManager = $this->getEntityManager();

        if (isset($updatedData['name'])) {
            $company->setName($updatedData['name']);
        }
        if (isset($updatedData['document'])) {
            $company->setDocument($updatedData['document']);
        }

        $company->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($company);
        $entityManager->flush();

        return $company;
    }

    public function SoftDelete(Company $company): Company
    {
        $entityManager = $this->getEntityManager();
        
        $company->setDeletedAt(new \DateTime());
        $entityManager->persist($company);
        $entityManager->flush();

        return $company;
    }
}
