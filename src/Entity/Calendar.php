<?php

namespace App\Entity;

// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarRepository")
 */
class Calendar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bgColor;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Service", cascade={"persist", "remove"})
     */
    private $service;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $type;

   
    // /**
    //  * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="calendar")
    //  */
    // private $evenements;

    // public function __construct()
    // {
    //     $this->evenements = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setBgColor(?string $bgColor): self
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    // /**
    //  * @return Collection|Evenement[]
    //  */
    // public function getEvenements(): Collection
    // {
    //     return $this->evenements;
    // }

    // public function addEvenement(Evenement $evenement): self
    // {
    //     if (!$this->evenements->contains($evenement)) {
    //         $this->evenements[] = $evenement;
    //         $evenement->setCalendar($this);
    //     }

    //     return $this;
    // }

    // public function removeEvenement(Evenement $evenement): self
    // {
    //     if ($this->evenements->contains($evenement)) {
    //         $this->evenements->removeElement($evenement);
    //         // set the owning side to null (unless already changed)
    //         if ($evenement->getCalendar() === $this) {
    //             $evenement->setCalendar(null);
    //         }
    //     }

    //     return $this;
    // }
   

   
  
    
    
    }

    
