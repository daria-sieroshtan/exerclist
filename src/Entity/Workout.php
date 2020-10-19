<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=WorkoutRepository::class)
 */
class Workout implements OwnableEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPrivate = false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="workouts")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Blameable(on="create")
     */
    private $user;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(
     *     targetEntity=WorkoutExercise::class,
     *     mappedBy="workout",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $workoutExercises;

    public function __construct()
    {
        $this->workoutExercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?int
    {
        return count($this->workoutExercises);
    }

    public function getIsPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return Collection|WorkoutExercise[]
     */
    public function getWorkoutExercises(): Collection
    {
        return $this->workoutExercises;
    }

    public function addWorkoutExercise(WorkoutExercise $workoutExercise): self
    {
        if (!$this->workoutExercises->contains($workoutExercise)) {
            $this->workoutExercises[] = $workoutExercise;
            $workoutExercise->setWorkout($this);
        }

        return $this;
    }

    public function removeWorkoutExercise(WorkoutExercise $workoutExercise): self
    {
        if ($this->workoutExercises->contains($workoutExercise)) {
            $this->workoutExercises->removeElement($workoutExercise);
            // set the owning side to null (unless already changed)
            if ($workoutExercise->getWorkout() === $this) {
                $workoutExercise->setWorkout(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $tags = [];

        foreach ($this->getWorkoutExercises() as $workoutExercise) {
            $exerciseTags = $workoutExercise->getExercise()->getTags();
            $tags = array_merge($tags, $exerciseTags->toArray());
        }

        return array_unique($tags);
    }

    public function getExercises()
    {
        $exercises = [];

        foreach ($this->getWorkoutExercises() as $workoutExercise) {
            $exercises = $this->insertItemIntoSequence($exercises, $workoutExercise->getSequentialNumber(), $workoutExercise->getExercise());
        }

        ksort($exercises);

        return $exercises;
    }

    public function insertItemIntoSequence($list, $seqNumber, $item)
    {
        if (key_exists($seqNumber, $list)) {
            return $this->insertItemIntoSequence($list, $seqNumber +1, $item );
        } else {
            $list[$seqNumber] = $item;
            return $list;
        }
    }
}
