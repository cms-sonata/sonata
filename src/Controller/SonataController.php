<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class SonataController
 * @package App\Controller
 */
class SonataController extends AbstractController
{

    /**
     * @Route("/", methods={"GET"}, name="index")
     * @Cache(smaxage="1")
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function index(Request $request): Response
    {
        return $this->render('sonata/index.html.twig', ['content' => 'HEEHEH']);
    }
}
