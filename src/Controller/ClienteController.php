<?php

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Cliente;
use Pidia\Apps\Demo\Form\ClienteType;
use Pidia\Apps\Demo\Manager\ClienteManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cliente')]
class ClienteController extends BaseController
{
    #[Route('/', name: 'cliente_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'cliente_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ClienteManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'cliente_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render('cliente/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route('/new', name: 'cliente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClienteManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'config_menu_index');
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($cliente)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('cliente_index');
        }

        return $this->render('cliente/new.html.twig', [
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'cliente_show', methods: ['GET'])]
    public function show(Cliente $cliente): Response
    {
        $this->denyAccess(Access::LIST, 'config_menu_index');

        return $this->render('cliente/show.html.twig', [
            'cliente' => $cliente,
        ]);
    }

    #[Route('/{id}/edit', name: 'cliente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cliente $cliente, ClienteManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'config_menu_index');
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($cliente)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('config_menu_index', ['id' => $cliente->getId()]);
        }

        return $this->render('cliente/edit.html.twig', [
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'cliente_delete', methods: ['POST'])]
    public function delete(Request $request, Cliente $cliente, ClienteManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'config_menu_index');
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $cliente->changeActivo();
            if ($manager->save($cliente)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('cliente_index');
    }

    #[Route(path: '/export', name: 'cliente_export', methods: ['GET'])]
    public function export(Request $request, ClienteManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'cliente_indes');
        $headers = [
            'nombreCliente' => 'Nombre',
            'apellidoCliente' => 'Apellido',
            'ruc' => 'Ruc',
            'direccion' => 'Dirección',
            'telefono' => 'Telefono',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'clientes');
    }

    #[Route(path: '/{id}/delete', name: 'cliente_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Cliente $cliente, ClienteManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'cliente_index', $cliente);
        if ($this->isCsrfTokenValid('delete_forever'.$cliente->getId(), $request->request->get('_token'))) {
            if ($manager->remove($cliente)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('cliente_index');
    }
}
