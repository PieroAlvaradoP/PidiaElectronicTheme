<?php

namespace Pidia\Apps\Demo\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Pidia\Apps\Demo\Entity\EquipoMarca;
use Pidia\Apps\Demo\Form\EquipoMarcaType;
use Pidia\Apps\Demo\Manager\EquipoMarcaManager;
use Pidia\Apps\Demo\Repository\EquipoMarcaRepository;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/marca')]
class EquipoMarcaController extends BaseController
{
//    #[Route('/', name: 'equipo_marca_index', methods: ['GET'])]
//    public function index(EquipoMarcaRepository $equipoMarcaRepository): Response
//    {
//        return $this->render('equipo_marca/index.html.twig', [
//            'equipo_marcas' => $equipoMarcaRepository->findAll(),
//        ]);
//    }

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
    public function new(Request $request, EquipoMarcaManager $entityManager): Response
    {
        $this->denyAccess(Access::NEW, 'equipo_marca_index');
        $equipoMarca = new EquipoMarca();
        $form = $this->createForm(EquipoMarcaType::class, $equipoMarca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($entityManager->save($equipoMarca)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($entityManager->errors());
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
        return $this->render('equipo_marca/show.html.twig', [
            'equipo_marca' => $equipoMarca,
        ]);
    }

    #[Route('/{id}/edit', name: 'equipo_marca_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipoMarca $equipoMarca, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipoMarcaType::class, $equipoMarca);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('equipo_marca_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipo_marca/edit.html.twig', [
            'equipo_marca' => $equipoMarca,
            'form' => $form,
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

        return $manager->exportOfQuery($request->query->all(), $headers, 'Reporte', 'config');
    }

    #[Route('/{id}', name: 'equipo_marca_delete', methods: ['POST'])]
    public function delete(Request $request, EquipoMarca $equipoMarca, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipoMarca->getId(), $request->request->get('_token'))) {
            $entityManager->remove($equipoMarca);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipo_marca_index', [], Response::HTTP_SEE_OTHER);
    }
}
