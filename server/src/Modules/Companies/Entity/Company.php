<?php

namespace App\Modules\Companies\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: "companies")]
class Company {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $document;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deleted_at = null;

    public function getId() {
        return $this->id;
    }

    public function setUuid($value) {
        if (is_string($value)) {
            $value = Uuid::fromString($value);
        }
        $this->uuid = $value; 
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setDocument(string $document) {
        $this->document = $document;
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
            'id' => $this->uuid->toRfc4122(),
            'name' => $this->name,
            'document' => $this->document
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
