<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * Professional
 *
 * @ORM\MappedSuperclass
 */
class Professional extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numProf;

    /**
     * @ORM\Column(type="string", length=195, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=195, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=195, nullable=true)
     */
    private $personOpeningAccount;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOpened;

  
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service")
     * @ORM\JoinColumn(nullable=true)
     */
    private $specialisation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumProf(): ?int
    {
        return $this->numProf;
    }

    public function setNumProf(?int $numProf): self
    {
        $this->numProf = $numProf;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPersonOpeningAccount(): ?string
    {
        return $this->personOpeningAccount;
    }

    public function setPersonOpeningAccount(?string $personOpeningAccount): self
    {
        $this->personOpeningAccount = $personOpeningAccount;

        return $this;
    }

    public function getDateOpened(): ?\DateTimeInterface
    {
        return $this->dateOpened;
    }

    public function setDateOpened(\DateTimeInterface $dateOpened): self
    {
        $this->dateOpened = $dateOpened;

        return $this;
    }

    
    public function getSpecialisation(): ?Service
    {
        return $this->specialisation;
    }

    public function setSpecialisation(?Service $specialisation): self
    {
        $this->specialisation = $specialisation;

        return $this;
    }
}
