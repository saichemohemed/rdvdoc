<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicalPersonalHistoryRepository")
 */
class MedicalPersonalHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $allergies;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $medicalHistories;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $surgicalHistories;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $traumaticHistories;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $obstetricalHistories;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $psychomotorDevelopment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $familysurgical;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $familymedical;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $psychiatric;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $toxic;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $prison;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $trauma;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $menarche;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $menopause;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $parity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $gravidity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cycle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dysmenorrhea;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dyspareunia;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $abundance;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $menstruationDuration;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $other;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $initialWeight;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cesarean;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $abortion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contraceptionType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Patient", mappedBy="medicalPersonalHistory", cascade={"persist", "remove"})
     */
    private $patient;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getMedicalHistories(): ?string
    {
        return $this->medicalHistories;
    }

    public function setMedicalHistories(?string $medicalHistories): self
    {
        $this->medicalHistories = $medicalHistories;

        return $this;
    }

    public function getSurgicalHistories(): ?string
    {
        return $this->surgicalHistories;
    }

    public function setSurgicalHistories(?string $surgicalHistories): self
    {
        $this->surgicalHistories = $surgicalHistories;

        return $this;
    }

    public function getTraumaticHistories(): ?string
    {
        return $this->traumaticHistories;
    }

    public function setTraumaticHistories(?string $traumaticHistories): self
    {
        $this->traumaticHistories = $traumaticHistories;

        return $this;
    }

    public function getObstetricalHistories(): ?string
    {
        return $this->obstetricalHistories;
    }

    public function setObstetricalHistories(?string $obstetricalHistories): self
    {
        $this->obstetricalHistories = $obstetricalHistories;

        return $this;
    }

    public function getPsychomotorDevelopment(): ?string
    {
        return $this->psychomotorDevelopment;
    }

    public function setPsychomotorDevelopment(?string $psychomotorDevelopment): self
    {
        $this->psychomotorDevelopment = $psychomotorDevelopment;

        return $this;
    }

    public function getFamilysurgical(): ?string
    {
        return $this->familysurgical;
    }

    public function setFamilysurgical(?string $familysurgical): self
    {
        $this->familysurgical = $familysurgical;

        return $this;
    }

    public function getFamilymedical(): ?string
    {
        return $this->familymedical;
    }

    public function setFamilymedical(?string $familymedical): self
    {
        $this->familymedical = $familymedical;

        return $this;
    }

    public function getPsychiatric(): ?string
    {
        return $this->psychiatric;
    }

    public function setPsychiatric(?string $psychiatric): self
    {
        $this->psychiatric = $psychiatric;

        return $this;
    }

    public function getToxic(): ?string
    {
        return $this->toxic;
    }

    public function setToxic(?string $toxic): self
    {
        $this->toxic = $toxic;

        return $this;
    }

    public function getPrison(): ?string
    {
        return $this->prison;
    }

    public function setPrison(?string $prison): self
    {
        $this->prison = $prison;

        return $this;
    }

    public function getTrauma(): ?string
    {
        return $this->trauma;
    }

    public function setTrauma(?string $trauma): self
    {
        $this->trauma = $trauma;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getMenarche(): ?string
    {
        return $this->menarche;
    }

    public function setMenarche(?string $menarche): self
    {
        $this->menarche = $menarche;

        return $this;
    }

    public function getMenopause(): ?string
    {
        return $this->menopause;
    }

    public function setMenopause(?string $menopause): self
    {
        $this->menopause = $menopause;

        return $this;
    }

    public function getParity(): ?string
    {
        return $this->parity;
    }

    public function setParity(?string $parity): self
    {
        $this->parity = $parity;

        return $this;
    }

    public function getGravidity(): ?string
    {
        return $this->gravidity;
    }

    public function setGravidity(?string $gravidity): self
    {
        $this->gravidity = $gravidity;

        return $this;
    }

    public function getCycle(): ?string
    {
        return $this->cycle;
    }

    public function setCycle(?string $cycle): self
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getDysmenorrhea(): ?string
    {
        return $this->dysmenorrhea;
    }

    public function setDysmenorrhea(?string $dysmenorrhea): self
    {
        $this->dysmenorrhea = $dysmenorrhea;

        return $this;
    }

    public function getDyspareunia(): ?string
    {
        return $this->dyspareunia;
    }

    public function setDyspareunia(?string $dyspareunia): self
    {
        $this->dyspareunia = $dyspareunia;

        return $this;
    }

    public function getAbundance(): ?string
    {
        return $this->abundance;
    }

    public function setAbundance(?string $abundance): self
    {
        $this->abundance = $abundance;

        return $this;
    }

    public function getMenstruationDuration(): ?string
    {
        return $this->menstruationDuration;
    }

    public function setMenstruationDuration(?string $menstruationDuration): self
    {
        $this->menstruationDuration = $menstruationDuration;

        return $this;
    }

    public function getOther(): ?string
    {
        return $this->other;
    }

    public function setOther(?string $other): self
    {
        $this->other = $other;

        return $this;
    }

    public function getInitialWeight(): ?string
    {
        return $this->initialWeight;
    }

    public function setInitialWeight(?string $initialWeight): self
    {
        $this->initialWeight = $initialWeight;

        return $this;
    }

    public function getCesarean(): ?string
    {
        return $this->cesarean;
    }

    public function setCesarean(?string $cesarean): self
    {
        $this->cesarean = $cesarean;

        return $this;
    }

    public function getAbortion(): ?string
    {
        return $this->abortion;
    }

    public function setAbortion(?string $abortion): self
    {
        $this->abortion = $abortion;

        return $this;
    }

    public function getContraceptionType(): ?string
    {
        return $this->contraceptionType;
    }

    public function setContraceptionType(?string $contraceptionType): self
    {
        $this->contraceptionType = $contraceptionType;

        return $this;
    }

 
    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        // set (or unset) the owning side of the relation if necessary
        $newMedicalPersonalHistory = $patient === null ? null : $this;
        if ($newMedicalPersonalHistory !== $patient->getMedicalPersonalHistory()) {
            $patient->setMedicalPersonalHistory($newMedicalPersonalHistory);
        }

        return $this;
    }
}
