<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kategorie
 *
 * @ORM\Table(name="kategorie")
 * @ORM\Entity
 */
class Kategorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcategory", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false, options={"comment"="lookup für logbuch.kategorie"})
     */
    private $categoryName;

    public function getIdcategory(): ?int
    {
        return $this->idcategory;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;
        return $this;
    }
}
