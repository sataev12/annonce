<?php

namespace App\Entity;

use App\Repository\ProduitLaitierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitLaitierRepository::class)]
class ProduitLaitier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $fromagesType = null;

    #[ORM\Column(length: 255)]
    private ?string $OrigineLait = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'produitLaitier')]
    private Collection $images;

    #[ORM\Column]
    private ?float $prix = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromagesType(): ?string
    {
        return $this->fromagesType;
    }

    public function setFromagesType(string $fromagesType): static
    {
        $this->fromagesType = $fromagesType;

        return $this;
    }

    public function getOrigineLait(): ?string
    {
        return $this->OrigineLait;
    }

    public function setOrigineLait(string $OrigineLait): static
    {
        $this->OrigineLait = $OrigineLait;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduitLaitierId($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduitLaitierId() === $this) {
                $image->setProduitLaitierId(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    
   

    

    
    
}
