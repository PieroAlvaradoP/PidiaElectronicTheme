<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\TecnicoEncargado;
use Pidia\Apps\Demo\Form\TecnicoEncargadoType;
use Pidia\Apps\Demo\Manager\TecnicoEncargadoManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tecnico')]
class TecnicoEncargadoController extends BaseController
{
    #[Route('/', name: 'tecnico_encargado_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'menu_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, TecnicoEncargadoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'tecnico_encargado_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('tecnico_encargado/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'tecnico_encargado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TecnicoEncargadoManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'tecnico_encargado_index');
        $tecnicoEncargado = new TecnicoEncargado();
        $form = $this->createForm(TecnicoEncargadoType::class, $tecnicoEncargado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tecnicoEncargado)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tecnico_encargado_index');
        }

        return $this->renderForm('tecnico_encargado/new.html.twig', [
            'tecnico_encargado' => $tecnicoEncargado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tecnico_encargado_show', methods: ['GET'])]
    public function show(TecnicoEncargado $tecnicoEncargado): Response
    {
        $this->denyAccess(Access::LIST, 'tecnico_encargado_index');

        return $this->render('tecnico_encargado/show.html.twig', [
            'tecnico_encargado' => $tecnicoEncargado,
        ]);
    }

    #[Route('/{id}/edit', name: 'tecnico_encargado_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        TecnicoEncargado $tecnicoEncargado,
        TecnicoEncargadoManager $manager
        ): Response {
        $this->denyAccess(Access::LIST, 'tecnico_encargado_index');
        $form = $this->createForm(TecnicoEncargadoType::class, $tecnicoEncargado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tecnicoEncargado)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->renderForm('tecnico_encargado/edit.html.twig', [
            'tecnico_encargado' => $tecnicoEncargado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tecnico_encargado_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        TecnicoEncargado $tecnicoEncargado,
        TecnicoEncargadoManager $manager
        ): Response {

        $this->denyAccess(Access::LIST, 'tecnico_encargado_index');
        if ($this->isCsrfTokenValid('delete'.$tecnicoEncargado->getId(), $request->request->get('_token'))) {
            $tecnicoEncargado->changeActivo();
            if ($manager->save($tecnicoEncargado)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tecnico_encargado_index');
    }

    #[Route(path: '/export', name: 'tecnico_encargado_export', methods: ['GET'])]
    public function export(Request $request, TecnicoEncargadoManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'tecnico_encargado_index');
        $headers = [
//            'nombreTecnico' => 'Nombre',
//            'apellidosTecnico' => 'Apellidos',
//            'dni' => 'DNI',
//            'direccion' => 'direccion',
//            'activo' => 'Activo',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'Reporte', 'tecnico_encargado');
    }

    #[Route(path: '/{id}/delete', name: 'tecnico_encargado_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, TecnicoEncargado $tecnicoEncargado,
                                  TecnicoEncargadoManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'tecnico_encargado_index', $tecnicoEncargado);
        if ($this->isCsrfTokenValid('delete_forever'.$tecnicoEncargado->getId(), $request->request->get('_token'))) {
            if ($manager->remove($tecnicoEncargado)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tecnico_encargado_index');
    }
}
