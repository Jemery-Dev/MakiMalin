<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: ListeDeCourses::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $listesDeCourse;

    #[ORM\ManyToMany(targetEntity: ListeCollaborative::class, inversedBy: 'utilisateurs')]
    private Collection $listesCollaborative;

    public function __construct()
    {
        $this->listesDeCourse = new ArrayCollection();
        $this->listesCollaborative = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        
        // Si le nom d'utilisateur est "minH", attribuez-lui le rôle ROLE_ADMIN
        if ($this->getUsername() === 'minH') {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, ListeDeCourses>
     */
    public function getListesDeCourse(): Collection
    {
        return $this->listesDeCourse;
    }

    public function addListesDeCourse(ListeDeCourses $listesDeCourse): static
    {
        if (!$this->listesDeCourse->contains($listesDeCourse)) {
            $this->listesDeCourse->add($listesDeCourse);
            $listesDeCourse->setUtilisateur($this);
        }

        return $this;
    }

    public function removeListesDeCourse(ListeDeCourses $listesDeCourse): static
    {
        if ($this->listesDeCourse->removeElement($listesDeCourse)) {
            // set the owning side to null (unless already changed)
            if ($listesDeCourse->getUtilisateur() === $this) {
                $listesDeCourse->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ListeCollaborative>
     */
    public function getListesCollaborative(): Collection
    {
        return $this->listesCollaborative;
    }

    public function addListesCollaborative(ListeCollaborative $listesCollaborative): static
    {
        if (!$this->listesCollaborative->contains($listesCollaborative)) {
            $this->listesCollaborative->add($listesCollaborative);
        }

        return $this;
    }

    public function removeListesCollaborative(ListeCollaborative $listesCollaborative): static
    {
        $this->listesCollaborative->removeElement($listesCollaborative);

        return $this;
    }
}
