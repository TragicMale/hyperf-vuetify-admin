<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller\Admin;

use App\Model\Resource;
use Hyperf\DbConnection\Db;
use App\Service\CasbinService;
use App\Controller\AbstractController;
use App\Request\Admin\ResourceRequest;

class ResourceController extends AbstractController
{

    public function index()
    {
        // sort paramters
        $perPage = intval($this->request->input('perPage'));
        $sortBy = $this->request->input('sortBy');
        $direction = $this->request->input('sortDirection');

        // query parameter
        $path = $this->request->input('path');
        $action = $this->request->input('action');
        $state = $this->request->input('state');

        $paginator = Resource::query()
            ->when($path, function ($query, $path) {
                return $query->where('path', 'like', $path . '%');
            })
            ->when($action, function ($query, $action) {
                return $query->where('action', $action);
            })
            ->when($state, function ($query, $state) {
                return $query->where('state', $state);
            })
            ->when($sortBy, function ($query, $sortBy) use ($direction) {
                return $query->orderBy($sortBy, $direction);
            }, function ($query) {
                return $query->orderBy('id', 'desc');
            })
            ->paginate($perPage);

        return $this->response->success([
            'total' => $paginator->total(),
            'data' => $paginator->items(),
        ]);
    }

    public function save(ResourceRequest $request)
    {
        $validated = $request->validated();
        $resource = new Resource();
        $resource->fill($validated);

        $result = $resource->save();
        return $this->response->success($result);
    }

    public function get(int $id)
    {
        $resource = Resource::query()->find($id);
        return $this->response->success($resource);
    }

    public function delete($id, CasbinService $casbinService)
    {
        // TODO
        Db::transaction(function () use ($id, $casbinService) {
            $resource = Resource::query()->find($id);
            $casbinService->deletePermission($resource->path, $resource->action);
            $resource->delete();
        });
        return $this->response->success(true);
    }
}
