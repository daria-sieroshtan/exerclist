<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use App\Service\Helper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PlaylistRepository::class)
 */
class Playlist implements OwnableEntityInterface
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="playlists")
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
     *     targetEntity=PlaylistTrack::class,
     *     mappedBy="playlist",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $playlistTracks;

    public function __construct()
    {
        $this->playlistTracks = new ArrayCollection();
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
     * @return Collection|PlaylistTrack[]
     */
    public function getPlaylistTracks(): Collection
    {
        return $this->playlistTracks;
    }

    public function addPlaylistTrack(PlaylistTrack $playlistTrack): self
    {
        if (!$this->playlistTracks->contains($playlistTrack)) {
            $this->playlistTracks[] = $playlistTrack;
            $playlistTrack->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistTrack(PlaylistTrack $playlistTrack): self
    {
        if ($this->playlistTracks->contains($playlistTrack)) {
            $this->playlistTracks->removeElement($playlistTrack);
            // set the owning side to null (unless already changed)
            if ($playlistTrack->getPlaylist() === $this) {
                $playlistTrack->setPlaylist(null);
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

        foreach ($this->getPlaylistTracks() as $playlistTrack) {
            $trackTags = $playlistTrack->getTrack()->getTags();
            $tags = array_merge($tags, $trackTags->toArray());
        }

        return array_unique($tags);
    }

    public function getTracks()
    {
        $playlistTracks = $this->getPlaylistTracks()->toArray();
        usort($playlistTracks, array("App\Helper", "compareItemsBySeqNumber"));
        $tracks = [];
        foreach ($playlistTracks as $playlistTrack) {
            $tracks[] = $playlistTrack->getTrack();
        }
        return $tracks;
    }
}
