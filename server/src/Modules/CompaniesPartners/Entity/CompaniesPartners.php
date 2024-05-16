<?php

namespace App\Modules\CompaniesPartners\Entity;

use App\Modules\Companies\Entity\Company;
use App\Modules\Partners\Entity\Partner;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CompaniesPartnersRepository')]
#[ORM\Table(name: 'companies_partners')]
class CompaniesPartners
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: 'App\Modules\Companies\Entity\Company')]
    #[ORM\JoinColumn(name: 'company_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $company_id;
    private $company;

    #[ORM\ManyToOne(targetEntity: 'App\Modules\Partners\Entity\Partner')]
    #[ORM\JoinColumn(name: 'partner_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $partner_id;
    private $partner;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deleted_at = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): self
    {
        $this->partner = $partner;
        return $this;
    }

    public function setCreatedAt($value) {
        $this->created_at = $value;
    }

    public function setUpdatedAt($value) {
        $this->updated_at = $value;
    }

    public function setDeletedAt($value) {
        $this->deleted_at = $value;
    }

    public function toArr(): array {
        return [
            'company' => $this->company_id->toArr(),
            'partner' => $this->partner_id->toArr(),
        ];
    }

    public static function formatAll(array $data): array {
        $formatted = [];
        
        foreach ($data as $key => $value) {
            $formatted[$key] = $value->toArr();
        }

        return $formatted;
    }
}
