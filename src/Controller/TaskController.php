<?php

namespace App\Controller;


use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Form\TaskType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include the Response and ResponseHeaderBag
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 *
 * @Route("/tasks")
 * @IsGranted("ROLE_USER")
 * 
 */
class TaskController extends Controller
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods="GET", name="task_index")
     * @Cache(smaxage="10")
     */
    public function index(Request $request, $page): Response
    {        
        $params = array();
        $searchData = $request->query->get('search');
        
               
        
        
        
        if( !empty($searchData['start_date']) )
            if (\DateTime::createFromFormat('Y-m-d', $searchData['start_date']) !== FALSE)
                $params['start_date'] = new \DateTime($searchData['start_date'].' 00:00:00');
            
            
        
        if( !empty($searchData['end_date']) )
            if (\DateTime::createFromFormat('Y-m-d', $searchData['end_date']) !== FALSE)    
                $params['end_date'] = new \DateTime($searchData['end_date'].' 23:59:59');
        
        $resAll = $this->getDoctrine()->getRepository(Task::class)->findResAll($this->getUser(), $params);
        
        
        
        
        if( isset($searchData['download']) ){            
            $res = $this->get('task.download')->downloadFile($searchData['download'], $resAll);  
            if( isset($res['filename']) ){
                $filename = $res['filename'];//'TextFile.txt';                        
                $fileContent = $res['fileContent'];//"Hello, this is the content of my File";                
                $response = new Response($fileContent);                
                $disposition = $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    $filename
                );                
                $response->headers->set('Content-Disposition', $disposition);                
                return $response;
            }
            else{//smth went wrong
                
            }
            
            
        }
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $resAll,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('task/index.html.twig', [
            'pagination' => $pagination,
            'params' => $params
        ]);
    }
    /**
     * @Route("/post", methods="GET|POST", name="task_post")
     */
    public function post(Request $request): Response
    {        
        $user = $this->getUser();
        $task = new Task();
        
        
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $task->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            
            
            
            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/post.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
