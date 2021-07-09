<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Calendar;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"Evenement" = "Evenement","PatientEvent" = "PatientEvent","RemindingEvent" = "RemindingEvent","UserEvent" = "UserEvent"})
 * @ORM\Table(name="evenement")
 */
class Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Calendar")
    //  * @ORM\JoinColumn(nullable=false)
    //  */
    // protected $calendar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startDatetime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endDatetime;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $bgColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $fgColor;

  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(?Calendar $calendar): self
    {
        $this->calendar = $calendar;

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

    public function getStartDatetime(): ?\DateTimeInterface
    {
        return $this->startDatetime;
    }

    public function setStartDatetime(\DateTimeInterface $startDatetime): self
    {
        $this->startDatetime = $startDatetime;

        return $this;
    }

    public function getEndDatetime(): ?\DateTimeInterface
    {
        return $this->endDatetime;
    }

    public function setEndDatetime(?\DateTimeInterface $endDatetime): self
    {
        $this->endDatetime = $endDatetime;

        return $this;
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

    public function getFgColor(): ?string
    {
        return $this->fgColor;
    }

    public function setFgColor(?string $fgColor): self
    {
        $this->fgColor = $fgColor;

        return $this;
    }


    // public function __toString() {
    //     return $this->getcalendar();
    //   }
    

}
