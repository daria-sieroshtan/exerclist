<?php

namespace App\Entity;

use App\Repository\WorkoutExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkoutExerciseRepository::class)
 */
class WorkoutExercise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Exercise::class, inversedBy="workoutExercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercise;

    /**
     * @ORM\ManyToOne(targetEntity=Workout::class, inversedBy="workoutExercises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workout;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequentialNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getWorkout(): ?Workout
    {
        return $this->workout;
    }

    public function setWorkout(?Workout $workout): self
    {
        $this->workout = $workout;

        return $this;
    }

    public function getSequentialNumber(): ?int
    {
        return $this->sequentialNumber;
    }

    public function setSequentialNumber(int $sequentialNumber): self
    {
        $this->sequentialNumber = $sequentialNumber;

        return $this;
    }
}
