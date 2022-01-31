<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\EquipoMarca;
use Pidia\Apps\Demo\Form\EquipoMarcaType;
use Pidia\Apps\Demo\Manager\EquipoMarcaManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/marca')]
class EquipoMarcaController extends BaseController
{
    #[Route('/', name: 'equipo_marca_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'menu_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EquipoMarcaManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'equipo_marca_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('equipo_marca/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'equipo_marca_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipoMarcaManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'equipo_marca_index');
        $equipoMarca = new EquipoMarca();
        $form = $this->createForm(EquipoMarcaType::class, $equipoMarca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($equipoMarca)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('equipo_marca_index');
        }

        return $this->render(
            'equipo_marca/new.html.twig',
            [
                'config' => $equipoMarca,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/{id}', name: 'equipo_marca_show', methods: ['GET'])]
    public function show(EquipoMarca $equipoMarca): Response
    {
        $this->denyAccess(Access::VIEW, 'equipo_marca_index');

        return $this->render('equipo_marca/show.html.twig', [
            'equipo_marca' => $equipoMarca,
        ]);
    }

    #[Route('/{id}/edit', name: 'equipo_marca_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipoMarca $equipoMarca, EquipoMarcaManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'equipo_marca_index');
        $form = $this->createForm(EquipoMarcaType::class, $equipoMarca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($equipoMarca)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('equipo_marca_index', ['id' => $equipoMarca->getId()]);
        }

        return $this->render('equipo_marca/edit.html.twig', [
            'equipo_marca' => $equipoMarca,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/export', name: 'equipo_marca_export', methods: ['GET'])]
    public function export(Request $request, EquipoMarcaManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'equipo_marca_index');
        $headers = [
//            'nombreMarca' => 'Nombre',
//            'detalleMarca' => 'Detalle',
//            'descripcion' => 'Descripcion',
//            'activo' => 'Activo',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'Reporte', 'equipo_marca');
    }

    #[Route('/{id}', name: 'equipo_marca_delete', methods: ['POST'])]
    public function delete(Request $request, EquipoMarca $equipoMarca, EquipoMarcaManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'equipo_marca_index');
        if ($this->isCsrfTokenValid('delete'.$equipoMarca->getId(), $request->request->get('_token'))) {
            $equipoMarca->changeActivo();
            if ($manager->save($equipoMarca)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('equipo_marca_index');
    }

    #[Route(path: '/{id}/delete', name: 'equipo_marca_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, EquipoMarca $equipoMarca, EquipoMarcaManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'equipo_marca_index', $equipoMarca);
        if ($this->isCsrfTokenValid('delete_forever'.$equipoMarca->getId(), $request->request->get('_token'))) {
            if ($manager->remove($equipoMarca)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('equipo_marca_index');
    }
}
