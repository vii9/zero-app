<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepositoryInterface;
use Barryvdh\Debugbar\Facades\Debugbar;


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
}
