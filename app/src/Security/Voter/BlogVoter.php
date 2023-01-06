<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BlogVoter extends Voter
{
    // Ici on met BLOG_EDIT pour s'adapter à notre code
    public const EDIT = 'BLOG_EDIT';
    // On enlève le view pck pas besoin
    // public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        // On remplace après le self:: par la const EDIT
        return in_array($attribute, [self::EDIT, self::EDIT])
            && $subject instanceof \App\Entity\Blog;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            // On enlève cela nous verrons ensuite pourquoi ...
            // case self::VIEW:
            //     // logic to determine if the user can VIEW
            //     // return true or false
            //     break;
        }

        return false;
    }
}
