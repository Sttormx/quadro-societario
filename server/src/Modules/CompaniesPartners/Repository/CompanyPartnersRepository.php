<?php
namespace App\Modules\CompaniesPartners\Repository;

use App\Modules\CompaniesPartners\Entity\CompaniesPartners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CompanyPartnersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompaniesPartners::class);
    }

    // public function Create(string $name, string $document): Company
    // {
    //     $entityManager = $this->getEntityManager();
    //     $company = new Company();
    //     $company->setUuid(Uuid::v7()->generate());
    //     $company->setName($name);
    //     $company->setDocument($document);
    //     $company->setCreatedAt(new \DateTimeImmutable());
        
    //     $entityManager->persist($company);
    //     $entityManager->flush();

    //     return $company;
    // }

    public function FindAllActiveByCompany($companyId): array {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c FROM App\Modules\CompaniesPartners\Entity\CompaniesPartners c WHERE c.deleted_at IS NULL AND c.company_id = :id'
        )->setParameter('id', $companyId);

        return $query->getResult();
    }
}
