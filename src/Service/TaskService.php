<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTask($title, $description)
    {
        $task = new Task();
        $task->setTitle($title);
        $task->setDescription($description);
        $task->setStatus('incomplete');

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    public function editTask($taskId, $title, $description)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        if ($task) {
            $task->setTitle($title);
            $task->setDescription($description);
            $this->entityManager->flush();
        }

        return $task;
    }

    public function deleteTask($taskId)
    {
        $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        if ($task) {
            $this->entityManager->remove($task);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    public function getTaskList()
    {
        return $this->entityManager->getRepository(Task::class)->findAll();
    }
}
