<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Table(name="patient")
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

   
    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $husbandsName;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $numCartechifae;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $familyStatus;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $EmergencyPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $traitingDoctor;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $bloodGroup;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MedicalPersonalHistory", inversedBy="patient", cascade={"persist", "remove"})
     */
    private $medicalPersonalHistory;

    /**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    private $referencedBy;

  
    

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getHusbandsName(): ?string
    {
        return $this->husbandsName;
    }

    public function setHusbandsName(?string $husbandsName): self
    {
        $this->husbandsName = $husbandsName;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }


    public function getNumCartechifae(): ?string
    {
        return $this->numCartechifae;
    }

    public function setNumCartechifae(?string $numCartechifae): self
    {
        $this->numCartechifae = $numCartechifae;

        return $this;
    }

    public function getFamilyStatus(): ?string
    {
        return $this->familyStatus;
    }

    public function setFamilyStatus(?string $familyStatus): self
    {
        $this->familyStatus = $familyStatus;

        return $this;
    }

    public function getEmergencyPhone(): ?string
    {
        return $this->EmergencyPhone;
    }

    public function setEmergencyPhone(?string $EmergencyPhone): self
    {
        $this->EmergencyPhone = $EmergencyPhone;

        return $this;
    }

    public function getTraitingDoctor(): ?string
    {
        return $this->traitingDoctor;
    }

    public function setTraitingDoctor(?string $traitingDoctor): self
    {
        $this->traitingDoctor = $traitingDoctor;

        return $this;
    }

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(?string $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getMedicalPersonalHistory(): ?MedicalPersonalHistory
    {
        return $this->medicalPersonalHistory;
    }

    public function setMedicalPersonalHistory(?MedicalPersonalHistory $medicalPersonalHistory): self
    {
        $this->medicalPersonalHistory = $medicalPersonalHistory;

        return $this;
    }

    public function getReferencedBy(): ?string
    {
        return $this->referencedBy;
    }

    public function setReferencedBy(?string $referencedBy): self
    {
        $this->referencedBy = $referencedBy;

        return $this;
    }

}
