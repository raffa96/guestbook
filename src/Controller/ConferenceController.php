<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(ConferenceRepository $conferenceRepository)
    {
        return new Response($this->twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll()
        ]));
    }

    /**
     * @Route("/conference/{id}", name="conference")
     */
    public function showConference(Request $request, Conference $conference, CommentRepository $commentRepository)
    {
        $offset = max(0, $request->query->getInt('offset', 0));

        $commentPaginator = $commentRepository->getCommentPaginator($conference, $offset);

        return new Response($this->twig->render('conference/conference.html.twig', [
            'conference' => $conference,
            'comments' => $commentPaginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PAGE,
            'next' => min(count($commentPaginator), $offset - CommentRepository::PAGINATOR_PAGE)
        ]));
    }
}