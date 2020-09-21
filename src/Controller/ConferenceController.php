<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Twig\Environment;

class ConferenceController extends AbstractController
{

	public function __construct(Environment $twig, EntityManagerInterface $entityManager)
	{
		$this->twig = $twig;
		$this->entityManager = $entityManager;
	}
	
	/**
	 * @Route("/", name="homepage")
	 */
	public function index(ConferenceRepository $conferenceRepository)
	{
		//dd($conferenceRepository->findAll());
		return new Response($this->twig->render('conference/index.html.twig', [
		]));
	}

	/**
	 * @Route("/conference/{slug}", name="conference")
	 */
	public function show(Request $request, Conference $conference, CommentRepository $commentRepository, ConferenceRepository $conferenceRepository, string $photoDir)
	{
	    $comment = new Comment();
	    $form = $this->createForm(CommentFormType::class, $comment);
	    $form->handleRequest($request);
	    if($form->isSubmitted() && $form->isValid()){
	        $comment->setConference($conference);
	        if($photo = $form['photo']->getData()){
	            $filename = bin2hex(random_bytes(6).'.'.$photo->guessExtension());
	            try{
	                $photo->move($photoDir, $filename);
                } catch(FileException $e){
	                // Unable to upload the photo, give up
                }
                $comment->setPhotoFileName($filename);
	        }

	        $this->entityManager->persist($comment);
	        $this->entityManager->flush();

	        return $this->redirectToRoute('conference', ['slug' => $conference->getSlug()]);
        }
		$offset = max(0, $request->query->getInt('offset',0));
		$paginator = $commentRepository->getCommentPaginator($conference,$offset);
		return new Response($this->twig->render('conference/show.html.twig',[
			'conference' => $conference,
			'comments' => $paginator,
			'comment_form' => $form->createView(),
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
			'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
		]));
	}
}
