<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Team;

final class TaskVoter extends Voter
{
    public const EDIT = 'TASK_EDIT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::EDIT && $subject instanceof Task;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if(!$user instanceof User){
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        return $task->getUser() === $user || $task->getTeam()->getOwner() === $user;
    }
}
