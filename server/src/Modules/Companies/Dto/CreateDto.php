<?php 
namespace App\Modules\Companies\Dto;

class CreateDto {
    public string $name;
    public string $document;

    public function __construct(string $name, string $document) {
        $this->name = $name;
        $this->document = $document;
    }

    public static function FromRequest(array $data): CreateDto {
        return new CreateDto(
            isset($data['name']) ? $data['name'] : '',
            isset($data['document']) ? $data['document'] : '',
        );
    }

    public function toArr(): array {
        $data = [];

        if (isset($this->name) && $this->name != '')
            $data['name'] = $this->name;
        
        if (isset($this->document) && $this->document != '')
            $data['document'] = $this->document;

        return $data;
    }
}