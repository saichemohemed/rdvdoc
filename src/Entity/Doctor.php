<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Professional;


/**
 * @ORM\Table(name="doctor")
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 */
class Doctor extends Professional
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $workingtime;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkingtime(): ?string
    {
        return $this->workingtime;
    }

    public function setWorkingtime(?string $workingtime): self
    {
        $this->workingtime = $workingtime;

        return $this;
    }

   

   
}
