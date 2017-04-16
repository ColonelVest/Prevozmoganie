<?php

namespace NotesBundle\Controller;

use BaseBundle\Controller\BaseApiController;
use BaseBundle\Services\EntityNormalizer;
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
     * @param Request $request
     * @param $noteId
     * @return array
     */
    public function getNoteAction(Request $request, $noteId)
    {
        return $this->getEntityResultById($request, $noteId);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function getNotesAction(Request $request)
    {
        $criteria = Criteria::create();

        return $this->getEntitiesByCriteria($request, $criteria);
    }

    /**
     * @Rest\View
     * @param $noteId
     * @param Request $request
     * @return array
     */
    public function deleteNoteAction($noteId, Request $request)
    {
        return $this->removeEntityById($noteId, $request);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @return array
     */
    public function postNotesAction(Request $request)
    {
        return $this->createEntity($request, Note::class, NoteType::class);
    }

    /**
     * @Rest\View
     * @param Request $request
     * @param $noteId
     * @return array
     */
    public function putNoteAction(Request $request, $noteId)
    {
        return $this->editEntity($request, $noteId, NoteType::class);
    }

    protected function getHandler(): EntityHandler
    {
        return $this->get('notes_handler');
    }

    protected function getNormalizer(): EntityNormalizer
    {
        return $this->get('notes_normalizer');
    }
}
