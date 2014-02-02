<?php

namespace nk\ExamBundle\Controller;

use nk\ExamBundle\Entity\Resource;
use nk\ExamBundle\Form\ResourceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class ExamController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Request
     */
    private $request;

    /**
     * @Template
     * @Secure(roles="ROLE_USER")
     */
    public function nextAction()
    {
        return array(
            'exams' => $this->em->getRepository('nkExamBundle:Exam')->findNext($this->getUser()),
        );
    }

    /**
     * @Template
     */
    public function updateAction()
    {
        $this->get('nk_exam.ade.explorer')->updateDatabase();
        return array(
        );
    }
}