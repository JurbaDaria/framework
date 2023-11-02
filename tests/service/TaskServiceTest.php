<?php
use App\Service\TaskService; 
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskServiceTest extends KernelTestCase
{
    public function testAddTask()
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();

        $taskService = $container->get(TaskService::class);

        $task = $taskService->addTask('Test Task');

        $this->assertSame('Test Task', $task->getTitle());
    }
}
