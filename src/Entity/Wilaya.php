<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WilayaRepository")
 */
class Wilaya
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Wilaya;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?int
    {
        return $this->Code_postal;
    }

    public function setCodePostal(int $Code_postal): self
    {
        $this->Code_postal = $Code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getWilaya(): ?string
    {
        return $this->Wilaya;
    }

    public function setWilaya(string $Wilaya): self
    {
        $this->Wilaya = $Wilaya;

        return $this;
    }
}
