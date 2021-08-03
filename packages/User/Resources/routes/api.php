<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

use EOffice\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/user'], function (Illuminate\Routing\Router $router) {
    $router->get('/', [UserController::class, 'index'])->name('eoffice.users.list');
    $router->post('/',[UserController::class, 'store'])->name('eoffice.users.store');
    $router->match(['PUT', 'PATCH'],'/{user}', [UserController::class, 'update'])->name('eoffice.users.update');
    $router->delete('/', [UserController::class, 'delete'])->name('eoffice.users.delete');
    $router->post('/detail', [UserController::class, 'detail'])->name('eoffice.users.detail');
});
