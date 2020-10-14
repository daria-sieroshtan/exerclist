<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Exercise::class, mappedBy="user")
     */
    private $exercises;

    /**
     * @ORM\OneToMany(targetEntity=ExerciseTag::class, mappedBy="user")
     */
    private $exerciseTags;

    /**
     * @ORM\OneToMany(targetEntity=Workout::class, mappedBy="user")
     */
    private $workouts;

    /**
     * @ORM\OneToMany(targetEntity=TrackTag::class, mappedBy="user")
     */
    private $trackTags;

    /**
     * @ORM\OneToMany(targetEntity=Track::class, mappedBy="user")
     */
    private $tracks;

    /**
     * @ORM\OneToMany(targetEntity=Playlist::class, mappedBy="user")
     */
    private $playlists;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
        $this->exerciseTags = new ArrayCollection();
        $this->workouts = new ArrayCollection();
        $this->trackTags = new ArrayCollection();
        $this->tracks = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises[] = $exercise;
            $exercise->setUser($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->contains($exercise)) {
            $this->exercises->removeElement($exercise);
            // set the owning side to null (unless already changed)
            if ($exercise->getUser() === $this) {
                $exercise->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExerciseTag[]
     */
    public function getExerciseTags(): Collection
    {
        return $this->exerciseTags;
    }

    public function addExerciseTag(ExerciseTag $exerciseTag): self
    {
        if (!$this->exerciseTags->contains($exerciseTag)) {
            $this->exerciseTags[] = $exerciseTag;
            $exerciseTag->setUser($this);
        }

        return $this;
    }

    public function removeExerciseTag(ExerciseTag $exerciseTag): self
    {
        if ($this->exerciseTags->contains($exerciseTag)) {
            $this->exerciseTags->removeElement($exerciseTag);
            // set the owning side to null (unless already changed)
            if ($exerciseTag->getUser() === $this) {
                $exerciseTag->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Workout[]
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): self
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts[] = $workout;
            $workout->setUser($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workouts->contains($workout)) {
            $this->workouts->removeElement($workout);
            // set the owning side to null (unless already changed)
            if ($workout->getUser() === $this) {
                $workout->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TrackTag[]
     */
    public function getTrackTags(): Collection
    {
        return $this->trackTags;
    }

    public function addTrackTag(TrackTag $trackTag): self
    {
        if (!$this->trackTags->contains($trackTag)) {
            $this->trackTags[] = $trackTag;
            $trackTag->setUser($this);
        }

        return $this;
    }

    public function removeTrackTag(TrackTag $trackTag): self
    {
        if ($this->trackTags->contains($trackTag)) {
            $this->trackTags->removeElement($trackTag);
            // set the owning side to null (unless already changed)
            if ($trackTag->getUser() === $this) {
                $trackTag->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Track[]
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): self
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks[] = $track;
            $track->setUser($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        if ($this->tracks->contains($track)) {
            $this->tracks->removeElement($track);
            // set the owning side to null (unless already changed)
            if ($track->getUser() === $this) {
                $track->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Playlist[]
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): self
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists[] = $playlist;
            $playlist->setUser($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): self
    {
        if ($this->playlists->contains($playlist)) {
            $this->playlists->removeElement($playlist);
            // set the owning side to null (unless already changed)
            if ($playlist->getUser() === $this) {
                $playlist->setUser(null);
            }
        }

        return $this;
    }
}
