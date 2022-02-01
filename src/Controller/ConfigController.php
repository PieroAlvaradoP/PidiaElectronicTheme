<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Controller;

use Pidia\Apps\Demo\Entity\Config;
use Pidia\Apps\Demo\Form\ConfigType;
use Pidia\Apps\Demo\Manager\ConfigManager;
use Pidia\Apps\Demo\Security\Access;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/config')]
final class ConfigController extends BaseController
{
    #[Route(path: '/', name: 'config_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'config_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ConfigManager $manager): Response
    {
        $this->denyAccess(Access::LIST, 'config_index');
        $paginator = $manager->list($request->query->all(), $page);

        return $this->render(
            'config/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'config_export', methods: ['GET'])]
    public function export(Request $request, ConfigManager $manager): Response
    {
        $this->denyAccess(Access::EXPORT, 'config_index');
        $headers = [
            'nombre' => 'Nombre',
            'alias' => 'Alias',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
        ];

        return $manager->exportOfQuery($request->query->all(), $headers, 'Reporte', 'config');
    }

    #[Route(path: '/new', name: 'config_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConfigManager $manager): Response
    {
        $this->denyAccess(Access::NEW, 'config_index');
        $config = new Config();
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($config)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('config_index');
        }

        return $this->render(
            'config/new.html.twig',
            [
                'config' => $config,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/show', name: 'config_show', methods: ['GET'])]
    public function show(Config $config): Response
    {
        $this->denyAccess(Access::VIEW, 'config_index');

        return $this->render('config/show.html.twig', ['config' => $config]);
    }

    #[Route(path: '/{id}/edit', name: 'config_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Config $config, ConfigManager $manager): Response
    {
        $this->denyAccess(Access::EDIT, 'config_index');
        $form = $this->createForm(ConfigType::class, $config);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($config)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('config_index', ['id' => $config->getId()]);
        }

        return $this->render(
            'config/edit.html.twig',
            [
                'config' => $config,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'config_delete', methods: ['POST'])]
    public function delete(Request $request, Config $config, ConfigManager $manager): Response
    {
        $this->denyAccess(Access::DELETE, 'config_index');
        if ($this->isCsrfTokenValid('delete'.$config->getId(), $request->request->get('_token'))) {
            $config->changeActivo();
            if ($manager->save($config)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('config_index');
    }

    #[Route(path: '/{id}/delete', name: 'config_delete_forever', methods: ['POST'])]
    public function deleteForever(Request $request, Config $config, ConfigManager $manager): Response
    {
        $this->denyAccess(Access::MASTER, 'config_index', $config);
        if ($this->isCsrfTokenValid('delete_forever'.$config->getId(), $request->request->get('_token'))) {
            if ($manager->remove($config)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('config_index');
    }
}
