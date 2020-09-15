<?php

namespace App\Handler;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * This class contains methods that require database to
 * perform some operations
 */
class PositionHandler
{
    private $entityManager;
    private $validator;
    private $csrfManager;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, CsrfTokenManagerInterface $csrfManager)
    {
        $this->entityManager = $em;
        $this->validator = $validator;
        $this->csrfManager = $csrfManager;
    }

    public function create(Position $position, $csrf = null)
    {
        //dump($position);
        //dump("using custom post method");
        // if ($csrf !== $this->csrfManager->getToken('form')->getValue()) {
        //     throw new InvalidCsrfTokenException('Invalid CSRF token');
        // }
        $this->validator->validate($position);

        $this->entityManager->persist($position);
        $this->entityManager->flush();
        return $position;
    }

    public function removePosition(Position $position, $csrf)
    {
        //dump($position);
        //dump("using custom post method");
        if ($csrf !== $this->csrfManager->getToken('form')->getValue()) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        $this->entityManager->remove($position);
        $this->entityManager->flush();
        return $position;
    }
}
