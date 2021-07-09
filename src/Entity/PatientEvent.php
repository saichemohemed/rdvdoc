<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Evenement as Evenement;

/**
 *
 * @ORM\Table(name="patientevent")
 * @ORM\Entity(repositoryClass="App\Repository\PatientEventRepository")
 */
class PatientEvent extends Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doctor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $doctor;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $TypeRdv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PatternType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $motif;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime")
     */
    private $updatedate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $NumberOfChangeDoctor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $NumberOfChangePatient;

   
    /**
     * Convert calendar event details to an array
     * 
     * @return array $event 
     */
    public function toArray()
    {
        $event = array();
        
        if ($this->id !== null) {
            $event['id'] = $this->id;
        }
		
		if ($this->Doctor !== null) {
            $event['idDoctor'] = $this->Doctor->getId();
        }
		if ($this->patient !== null) {
            $event['idPatient'] = $this->patient->getId();
        }
		
		if ($this->calendar !== null) {
            $event['idCalendar'] = $this->calendar->getId();
        }
        
        $event['title'] = $this->title;
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:sP");
        
        
        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }
        
        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }
        
        if ($this->cssClass !== null) {
            $event['className'] = $this->cssClass;
        }

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:sP");
        }
        
        $event['allDay'] = $this->allDay;

        foreach ($this->otherFields as $field => $value) {
            $event[$field] = $value;
        }
        
        return $event;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }


    /**
     * @param string $name
     * @param string $value
     */
    public function addField($name, $value)
    {
        $this->otherFields[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function removeField($name)
    {
        if (!array_key_exists($name, $this->otherFields)) {
            return;
        }

        unset($this->otherFields[$name]);
    }

    public function getTypeRdv(): ?string
    {
        return $this->TypeRdv;
    }

    public function setTypeRdv(string $TypeRdv): self
    {
        $this->TypeRdv = $TypeRdv;

        return $this;
    }

    public function getMotif(): ?PatternType
    {
        return $this->motif;
    }

    public function setMotif(?PatternType $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getUpdatedate(): ?\DateTimeInterface
    {
        return $this->updatedate;
    }

    public function setUpdatedate(\DateTimeInterface $updatedate): self
    {
        $this->updatedate = $updatedate;

        return $this;
    }


    public function getNumberOfChangeDoctor(): ?bool
    {
        return $this->NumberOfChangeDoctor;
    }

    public function setNumberOfChangeDoctor(bool $NumberOfChangeDoctor): self
    {
        $this->NumberOfChangeDoctor = $NumberOfChangeDoctor;

        return $this;
    }

    public function getNumberOfChangePatient(): ?bool
    {
        return $this->NumberOfChangePatient;
    }

    public function setNumberOfChangePatient(bool $NumberOfChangePatient): self
    {
        $this->NumberOfChangePatient = $NumberOfChangePatient;

        return $this;
    }

   


  
   
}
