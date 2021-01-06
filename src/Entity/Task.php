<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(min=2, minMessage="task.too_short_title")
     * @Assert\NotBlank
     */
    private $title;



    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="task.blank_comment")
     * @Assert\Length(min=10, minMessage="task.too_short_comment")
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $dateAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="integer")
     */
    private $timespent;
    

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;



    public function __construct()
    {
        $this->dateAt = new \DateTime();
        $this->timespent = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    
    public function getTimespent(): ?int
    {
        return $this->timespent;
    }

    public function setTimespent(int $timespent): void
    {
        $this->timespent = $timespent;
    }


    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getDateAt(): \DateTime
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTime $dateAt): void
    {
        $this->dateAt = $dateAt;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}
