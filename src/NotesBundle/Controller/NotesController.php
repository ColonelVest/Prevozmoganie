<?php

namespace NotesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotesController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    }

}
