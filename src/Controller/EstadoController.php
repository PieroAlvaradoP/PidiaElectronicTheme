<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Estado;
use Pidia\Apps\Demo\Form\EstadoType;
use Pidia\Apps\Demo\Manager\EstadoManager;
use Pidia\Apps\Demo\Manager\TecnicoEncargadoManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/estado')]
class EstadoController extends BaseController
{
    #[Route('/', name: 'estado_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'estado_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EstadoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'estado_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('estado/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'estado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EstadoManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'estado_index');
        $estado = new Estado();
        $form = $this->createForm(EstadoType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($estado)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('estado_index');
        }

        return $this->render('estado/new.html.twig', [
            'estado' => $estado,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'estado_show', methods: ['GET'])]
    public function show(Estado $estado): Response
    {
        $this->denyAccess(Access::VIEW, 'estado_index');

        return $this->render('estado/show.html.twig', [
            'estado' => $estado,
        ]);
    }

    #[Route('/{id}/edit', name: 'estado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estado $estado, EstadoManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'estado_index');
        $form = $this->createForm(EstadoType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($estado)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->render('estado/edit.html.twig', [
            'estado' => $estado,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'estado_delete', methods: ['POST'])]
    public function delete(Request $request, Estado $estado, EstadoManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'estado_index');
        if ($this->isCsrfTokenValid('delete'.$estado->getId(), $request->request->get('_token'))) {
            $estado->changeActivo();
            if ($manager->save($estado)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('estado_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/export', name: 'estado_export', methods: ['GET'])]
    public function export(Request $request, EstadoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'estado_index');
        $headers = [
            'nombreEstado' => 'Estado',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'estado', 'estado');
    }

    #[Route(path: '/{id}/delete', name: 'estado_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Estado $tecnicoEncargado,
                                  EstadoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'estado_index', $tecnicoEncargado);
        if ($this->isCsrfTokenValid('delete_forever'.$tecnicoEncargado->getId(), $request->request->get('_token'))) {
            if ($manager->remove($tecnicoEncargado)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('estado_index');
    }

}
