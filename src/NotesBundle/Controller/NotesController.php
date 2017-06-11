<?php

namespace NotesBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityHandler;
use Doctrine\Common\Collections\Criteria;
use NotesBundle\Entity\Note;
use NotesBundle\Form\NoteType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class NotesController extends BaseApiController
{
    /**
     * @Rest\View
     * @param $noteId
     * @return array
     */
    public function getNoteAction($noteId)
    {
        return $this->getEntityResultById($noteId);
    }

    /**
     * @Rest\View
     * @return array
     */
    public function getNotesAction()
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($criteria);
    }

    /**
     * @Rest\View
     * @param $noteId
     * @return array
     */
    public function deleteNoteAction($noteId)
    {
        return $this->removeEntityById($noteId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postNotesAction(Request $request)
    {
        return $this->createEntity(Note::class, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $noteId
     * @return array
     */
    public function putNoteAction(Request $request, $noteId)
    {
        return $this->editEntity($request, $noteId);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('notes_handler');
    }
}
