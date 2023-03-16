<?php

declare(strict_types=1);

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="User\Repository\UserRepository")
 */
class User
{
    const GENDER = [1 => 'Male', 2 => 'Female', 3 => 'Other'];
    
    const STATUS = [1 => 'In-Active', 2 => 'Pending', 3 => 'Active'];

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="firstname", type="string", nullable=false)
     */
    private $firstName;

    /**
     * @ORM\Column(name="lastname", type="string", nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(name="contact", type="integer", nullable=false)
     */
    private $contact;

    /**
     * @ORM\Column(name="gender", type="integer", nullable=false)
     */
    private $gender;

    /**
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @ORM\Column(name="profilephoto", type="string", nullable=false)
     */
    private $profilePhoto;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $firstName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getContact(): int
    {
        return $this->contact;
    }

    /**
     * @param int $contact
     */
    public function setContact(int $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getProfilePhoto(): string
    {
        return $this->profilePhoto;
    }

    /**
     * @param string $profilePhoto
     */
    public function setProfilePhoto(string $profilePhoto): void
    {
        $this->profilePhoto = $profilePhoto;
    }
}
