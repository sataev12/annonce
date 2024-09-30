<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(targetEntity: ProduitLaitier::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProduitLaitier $produitLaitier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getProduitLaitier(): ?ProduitLaitier
    {
        return $this->produitLaitier;
    }

    public function setProduitLaitier(?ProduitLaitier $produitLaitier): self
    {
        $this->produitLaitier = $produitLaitier;

        return $this;
    }
}
