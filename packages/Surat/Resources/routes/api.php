<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use EOffice\Surat\Controller\SuratKeluarController;
use EOffice\Surat\Controller\SuratMasukController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/surat-masuk'], function (Router $router) {
    $router->get('/', [SuratMasukController::class, 'index'])->name('eoffice.surat_masuk.list');
    $router->post('/', [SuratMasukController::class, 'create'])->name('eoffice.surat_masuk.create');
    $router->post('/edit', [SuratMasukController::class, 'update'])->name('eoffice.surat_masuk.update');
    $router->delete('/', [SuratMasukController::class, 'delete'])->name('eoffice.surat_masuk.delete');
});

Route::group(['prefix' => '/surat-keluar'], function (Router $router) {
    $router->get('/', [SuratKeluarController::class, 'index'])->name('eoffice.surat_keluar.list');
    $router->post('/', [SuratKeluarController::class, 'create'])->name('eoffice.surat_keluar.create');
    $router->delete('/', [SuratKeluarController::class, 'delete'])->name('eoffice.surat_keluar.delete');
    $router->post('/edit', [SuratKeluarController::class, 'update'])->name('eoffice.surat_keluar.update');
    $router->post('/show', [SuratKeluarController::class, 'index'])->name('eoffice.surat_keluar.show');
});
