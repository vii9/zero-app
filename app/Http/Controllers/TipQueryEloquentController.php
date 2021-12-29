<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepositoryInterface;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;


class TipQueryEloquentController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    private $_postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->_postRepo = $postRepo;
    }

    public function getPostByUserHasRole($role_name = 'editor')
    {
        $posts = $this->_postRepo->getPostByUserHasRole($role_name);
        Debugbar::info($posts->toArray());
        return 'ok';
    }

    /**
     * @Description Using Redis Cache default
     * redis-cli \ select 1 \ KEYS *post_id*
     * @config .env : CACHE_DRIVER=redis \ REDIS_HOST=c-redis container onDocker
     * @config mysqlDocker: DB_HOST=c-mysql \ hediSQL PORT=33069
     * @docker: redis \ $ docker run --name c-redis -h h-redis -p 6379:6379 --network isnet -d redis
     * @docker: nginx \ $ docker run -it --name c-nginx -h h-webserver --network isnet -p 80:80 -p 443:443 -v /mnt/c/laragon/www/zero:/usr/share/nginx/html -v /mnt/d/2022/pro/nginx/default.conf:/etc/nginx/conf.d/default.conf -d web-nginx:php8
     * @docker: mysql \ $ docker run --name c-mysql -it -h h-mysql --network isnet -e MYSQL_ROOT_PASSWORD=zxcv -v /mnt/d/2022/pro/mysqldb/data:/var/lib/mysql -d mysql:latest --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
     *
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getPostById($id)
    {

        $postCache = Cache::remember(sprintf('post_id_%s', $id), now()->addMinutes(3), function() use ($id) {
            return $this->_postRepo->getPostById($id);
        });
        return view('hi', compact('postCache'));
    }
}
