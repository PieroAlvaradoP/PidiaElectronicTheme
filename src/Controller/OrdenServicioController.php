<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\OrdenServicio;
use Pidia\Apps\Demo\Form\OrdenServicioType;
use Pidia\Apps\Demo\Manager\OrdenServicioManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/orden')]
class OrdenServicioController extends BaseController
{
    #[Route('/', name: 'orden_servicio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'orden_servicio_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, OrdenServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'orden_servicio_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('orden_servicio/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'orden_servicio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdenServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'orden_servicio_index');
        $ordenServicio = new OrdenServicio();
        $form = $this->createForm(OrdenServicioType::class, $ordenServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($ordenServicio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('orden_servicio_index');
        }

        return $this->render('orden_servicio/new.html.twig', [
            'orden_servicio' => $ordenServicio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'orden_servicio_show', methods: ['GET'])]
    public function show(OrdenServicio $ordenServicio): Response
    {
        $this->denyAccess(Access::LIST, 'orden_servicio_index');
        return $this->render('orden_servicio/show.html.twig', [
            'orden_servicio' => $ordenServicio,
        ]);
    }

    #[Route('/{id}/edit', name: 'orden_servicio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrdenServicio $ordenServicio, OrdenServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'orden_servicio_index');
        $form = $this->createForm(OrdenServicioType::class, $ordenServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($ordenServicio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('orden_servicio_index', ['id' => $ordenServicio->getId()]);
        }

        return $this->render('orden_servicio/edit.html.twig', [
            'orden_servicio' => $ordenServicio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'orden_servicio_delete', methods: ['POST'])]
    public function delete(Request $request, OrdenServicio $ordenServicio, OrdenServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'orden_servicio_index');
        if ($this->isCsrfTokenValid('delete'.$ordenServicio->getId(), $request->request->get('_token'))) {
            $ordenServicio->changeActivo();
            if ($manager->save($ordenServicio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('orden_servicio_index');
    }

    #[Route(path: '/export', name: 'orden_servicio_export', methods: ['GET'])]
    public function export(Request $request, OrdenServicioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'orden_servicio_index');
        $headers = [
//            'nombreMarca' => 'Nombre',
//            'detalleMarca' => 'Detalle',
//            'descripcion' => 'Descripcion',
//            'activo' => 'Activo',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'Ordenes', 'orden_servicio');
    }

    #[Route(path: '/{id}/delete', name: 'orden_servicio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, OrdenServicio $ordenServicio, OrdenServicioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'orden_servicio_index', $ordenServicio);
        if ($this->isCsrfTokenValid('delete_forever'.$ordenServicio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($ordenServicio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('orden_servicio_index');
    }
}
