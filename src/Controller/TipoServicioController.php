<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\TipoServicio;
use Pidia\Apps\Demo\Form\TipoServicioType;
use Pidia\Apps\Demo\Manager\TipoServicioManager;
use Pidia\Apps\Demo\Security\Access;
use Pidia\Apps\Demo\Util\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/servicio')]
class TipoServicioController extends BaseController
{
    #[Route('/', name: 'tipo_servicio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'menu_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, TipoServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'tipo_servicio_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('tipo_servicio/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'tipo_servicio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TipoServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'tipo_servicio_index');
        $tipoServicio = new TipoServicio();
        $form = $this->createForm(TipoServicioType::class, $tipoServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipoServicio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipo_servicio_index');
        }

        return $this->render('tipo_servicio/new.html.twig', [
            'tipo_servicio' => $tipoServicio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'tipo_servicio_show', methods: ['GET'])]
    public function show(TipoServicio $tipoServicio): Response
    {
        $this->denyAccess(Access::LIST, 'tipo_servicio_index');

        return $this->render('tipo_servicio/show.html.twig', [
            'tipo_servicio' => $tipoServicio,
        ]);
    }

    #[Route('/{id}/edit', name: 'tipo_servicio_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        TipoServicio $tipoServicio,
        TipoServicioManager $manager
    ): Response {
        $this->denyAccess(Access::LIST, 'tipo_servicio_index');
        $form = $this->createForm(TipoServicioType::class, $tipoServicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipoServicio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->render('tipo_servicio/edit.html.twig', [
            'tipo_servicio' => $tipoServicio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'tipo_servicio_delete', methods: ['POST'])]
    public function delete(Request $request, TipoServicio $tipoServicio, TipoServicioManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'tipo_servicio_index');
        if ($this->isCsrfTokenValid('delete'.$tipoServicio->getId(), $request->request->get('_token'))) {
            $tipoServicio->changeActivo();
            if ($manager->save($tipoServicio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipo_servicio_index');
    }

    #[Route(path: '/export', name: 'tipo_servicio_export', methods: ['GET'])]
    public function export(Request $request, TipoServicioManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'tipo_servicio_index');
        $headers = [
            'nombreServicio' => 'Nombre',
            'detalleServicio' => 'Detalle',
        ];
        $params = Paginator::params($request->query->all());
        $objetos = $manager->repositorio()->filter($params, false);
        $data = [];
        /** @var TipoServicio $objeto */
        foreach ($objetos as $objeto) {
            $item = [];
            $item['nombreServicio'] = $objeto->getNombreServicio();
            $item['detalleServicio'] = $objeto->getDetalleServicio();
            $data[] = $item;
        }

        return $manager->export($data, $headers, 'Reporte Tipo de Servicio', 'TipoServicio');
    }

//    #[Route(path: '/export', name: 'tipo_servicio_export', methods: ['GET'])]
//    public function export(Request $request, TipoServicioManager $manager): Response
//    {
//        $this->denyAccess(Access::EXPORT, 'tipo_servicio_index');
//        $headers = [
//            'nombreServicio' => 'Nombre',
//            'detalleServicio' => 'Detalle',
//        ];
//
//        $params = Paginator::params($request->query->all());
//        $objetos = $manager->repositorio()->filter($params, false);
//        $data = [];
//        /** @var TipoServicio $objeto */
//        foreach ($objetos as $objeto) {
//            $item = [];
//            $item['nombreServicio'] = $objeto->getNombreServicio();
//            $item['detalleServicio'] = $objeto->getDetalleServicio();
//            $data[] = $item;
    ////            unset($item);
//        }
//
//        return $manager->export($data, $headers, 'Tipo_servicio', 'TipoServicio');
    ////        return $manager->exportOfQuery($request->query->all(), $headers, 'Reporte', 'usuario');
//    }

    #[Route(path: '/{id}/delete', name: 'tipo_servicio_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request,
                                  TipoServicio $tipoServicio,
                                  TipoServicioManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'tipo_servicio_index', $tipoServicio);
        if ($this->isCsrfTokenValid('delete_forever'.$tipoServicio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($tipoServicio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipo_servicio_index');
    }
}
