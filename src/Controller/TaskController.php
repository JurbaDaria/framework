<?php

namespace App\Controller;

use App\Entity\Task; 
use App\Form\TaskType; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Paginator\Paginator;
use Symfony\Component\Paginator\Adapter\AdapterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;


#[IsGranted('IS_AUTHENTICATED_FULLY')]
class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function list(PaginatorInterface $paginator, Request $request,EntityManagerInterface $entityManager): Response
    {
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $repository->findAll();

        $pagination = $paginator->paginate(
            $tasks,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('tasks/list.html.twig', [
            'tasks' => $pagination,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_view')]
    public function view(Task $task): Response
    {
        if (!$task) {
            throw $this->createNotFoundException('Task not found');
        }

        return $this->render('tasks/view.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/task/create', name: 'app_task_create')]
    public function create(Request $request): Response
    {
        
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task'); // Перенаправляем на список задач
        }

        return $this->render('tasks/create.html.twig', [
            'form' => $form->createView(),
        ]);
        $this->denyAccessUnlessGranted('ROLE_ADMIN', message: 'Access Denied for You');
    }

    #[Route('/task/{id}/update', name: 'app_task_update')]
    public function update(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_task'); // Перенаправляем на список задач
        }

        return $this->render('tasks/update.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/{id}/delete', name: 'app_task_delete')]
    public function delete(Task $task): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_task'); // Перенаправляем на список задач
    }
}
