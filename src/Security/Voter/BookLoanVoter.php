<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookLoanVoter extends Voter
{

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your logic
        return in_array($attribute, ['BOOK_LOAN'])
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // you know $subject is a Book object, thanks to supports method
        /** @var Book $book */
        $book = $subject;

        // replace with your logic
        return $book->getLoaner() === $user;
    }
}