<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Equipo;
use Pidia\Apps\Demo\Form\EquipoType;
use Pidia\Apps\Demo\Manager\EquipoManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/equipo')]
class EquipoController extends BaseController
{
    #[Route('/', name: 'equipo_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'equipo_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'equipo_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('equipo/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'equipo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'equipo_index');
        $equipo = new Equipo();
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($equipo)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('equipo_index');
        }

        return $this->render('equipo/new.html.twig', [
            'equipo' => $equipo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'equipo_show', methods: ['GET'])]
    public function show(Equipo $equipo): Response
    {
        $this->denyAccess(Access::LIST, 'equipo_index');

        return $this->render('equipo/show.html.twig', [
            'equipo' => $equipo,
        ]);
    }

    #[Route('/{id}/edit', name: 'equipo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipo $equipo, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'equipo_index');
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($equipo)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('equipo_index', ['id' => $equipo->getId()]);
        }

        return $this->render('equipo/edit.html.twig', [
            'equipo' => $equipo,
            'form' => $form->createView(),
            ]);
    }

    #[Route('/{id}', name: 'equipo_delete', methods: ['POST'])]
    public function delete(Request $request, Equipo $equipo, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'equipo_index');
        if ($this->isCsrfTokenValid('delete'.$equipo->getId(), $request->request->get('_token'))) {
            $equipo->changeActivo();
            if ($manager->save($equipo)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('equipo_index');
    }

    #[Route(path: '/export', name: 'equipo_export', methods: ['GET'])]
    public function export(Request $request, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'equipo_marca_index');
        $headers = [
//            'nombreMarca' => 'Nombre',
//            'detalleMarca' => 'Detalle',
//            'descripcion' => 'Descripcion',
//            'activo' => 'Activo',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'Equipo', 'equipo');
    }

    #[Route(path: '/{id}/delete', name: 'equipo_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Equipo $equipo, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'equipo_index', $equipo);
        if ($this->isCsrfTokenValid('delete_forever'.$equipo->getId(), $request->request->get('_token'))) {
            if ($manager->remove($equipo)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('equipo_index');
    }

}
