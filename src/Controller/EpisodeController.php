<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Form\CommentType;
use App\Form\EpisodeType;
use App\Repository\EpisodeRepository;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/episode")
 */
class EpisodeController extends AbstractController
{
    /**
     * @Route("/", name="episode_index", methods={"GET"})
     */
    public function index(EpisodeRepository $episodeRepository): Response
    {
        return $this->render('episode/index.html.twig', [
            'episodes' => $episodeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="episode_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer, Slugify $slugify): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $slug = $slugify->generate($episode->getTitle());
            $episode->setSlug($slug);

            $entityManager->persist($episode);
            $entityManager->flush();

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('rider_email@example.com')
                ->subject('Une nouvelle episode vient d\'être publiée !')
                ->html($this->renderView('episode/newEpisodeEmail.html.twig', ['episode' => $episode]));

            $mailer->send($email);

            return $this->redirectToRoute('episode_index');
        }

        return $this->render('episode/new.html.twig', [
            'episode' => $episode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="episode_show", methods={"GET", "POST"})
     */
    public function show(Episode $episode, Request $request): Response
    {
        $comment = new Comment();
        $formCommentView = $this->createForm(CommentType::class, $comment);
        $formCommentView->handleRequest($request);

        $user = $this->getUser();

        if ($formCommentView->isSubmitted() && $formCommentView->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setAuthor($user)
                ->setEpisode($episode);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('episode_show', ['slug' => $episode->getSlug()]);
        }
        return $this->render('episode/show.html.twig', [
            'episode' => $episode,
            'formCommentView' => $formCommentView->createView(),
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="episode_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Episode $episode): Response
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('episode_index');
        }

        return $this->render('episode/edit.html.twig', [
            'episode' => $episode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="episode_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$episode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($episode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('episode_index');
    }
}
