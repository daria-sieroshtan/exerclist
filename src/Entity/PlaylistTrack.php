<?php

namespace App\Entity;

use App\Repository\PlaylistTrackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaylistTrackRepository::class)
 */
class PlaylistTrack implements ItemOfSequenceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Playlist::class, inversedBy="playlistTracks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $playlist;

    /**
     * @ORM\ManyToOne(targetEntity=Track::class, inversedBy="playlistTracks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $track;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequentialNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getTrack(): ?Track
    {
        return $this->track;
    }

    public function setTrack(?Track $track): self
    {
        $this->track = $track;

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
