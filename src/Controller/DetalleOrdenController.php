<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\DetalleOrden;
use Pidia\Apps\Demo\Entity\Equipo;
use Pidia\Apps\Demo\Form\DetalleOrdenType;
use Pidia\Apps\Demo\Manager\DetalleOrdenManager;
use Pidia\Apps\Demo\Manager\EquipoManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/detalle')]
class DetalleOrdenController extends BaseController
{
    #[Route('/', name: 'detalle_orden_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'detalle_orden_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, DetalleOrdenManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'detalle_orden_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('detalle_orden/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'detalle_orden_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DetalleOrdenManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'detalle_orden_index');
        $detalleOrden = new DetalleOrden();
        $form = $this->createForm(DetalleOrdenType::class, $detalleOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($detalleOrden)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->render('detalle_orden/new.html.twig', [
            'detalle_orden' => $detalleOrden,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detalle_orden_show', methods: ['GET'])]
    public function show(DetalleOrden $detalleOrden): Response
    {
        $this->denyAccess(Access::VIEW, 'detalle_orden_index');

        return $this->render('detalle_orden/show.html.twig', [
            'detalle_orden' => $detalleOrden,
        ]);
    }

    #[Route('/{id}/edit', name: 'detalle_orden_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetalleOrden $detalleOrden, DetalleOrdenManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'detalle_orden_index');
        $form = $this->createForm(DetalleOrdenType::class, $detalleOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($detalleOrden)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }
            return $this->redirectToRoute('equipo_index', ['id' => $detalleOrden->getId()]);
        }

        return $this->render('detalle_orden/edit.html.twig', [
            'detalle_orden' => $detalleOrden,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detalle_orden_delete', methods: ['POST'])]
    public function delete(Request $request, DetalleOrden $detalleOrden, DetalleOrdenManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'detalle_orden_index');
        if ($this->isCsrfTokenValid('delete'.$detalleOrden->getId(), $request->request->get('_token'))) {
            $detalleOrden->changeActivo();
            if ($manager->save($detalleOrden)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('detalle_orden_index');
    }

    #[Route(path: '/export', name: 'detalle_orden_export', methods: ['GET'])]
    public function export(Request $request, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'detalle_orden_index');
        $headers = [
//            'nombreMarca' => 'Nombre',
//            'detalleMarca' => 'Detalle',
//            'descripcion' => 'Descripcion',
//            'activo' => 'Activo',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'Equipo', 'equipo');
    }

    #[Route(path: '/{id}/delete', name: 'detalle_orden_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Equipo $equipo, EquipoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'detalle_orden_index', $equipo);
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
