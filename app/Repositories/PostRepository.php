<?php


namespace App\Repositories;


use App\Constant\RoleConstant;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    /**
     * @var Post
     */
    private $_postModel;

    public function __construct(Post $post)
    {

        $this->_postModel = $post;
    }

    public function getPostByUserHasRole($role_name)
    {
        if ( ! in_array($role_name, RoleConstant::ROLE_NAME_ALL)) {
            abort(404, sprintf('ERROR! role name %s not exists', $role_name));
        }

        $posts = $this->_postModel->select('id', 'user_id', 'title', 'content')
            ->whereHas('user.roles', function($query) use ($role_name) {
                $query->where('roles.name_column', '=', $role_name);
            })
            #->with('user.roles') // can comment it if don't use
            ->with(['user.roles' => function($query) use ($role_name) {
                $query->select('id', 'name_column', 'name_role')->where('roles.name_column', '=', $role_name);
            }])
            ->with(['user' => function($query) {
                $query->select('id', 'name');
            }])
            ->get();

        return $posts;
    }
}

/* sql explain query
//fn_getPostByUserHasRole//
EXPLAIN
SELECT
 `id`,
 `user_id`,
 `title`,
 `content`
FROM
 `posts`
WHERE EXISTS (
	SELECT
	 *
	FROM
	 `users`
	WHERE
	 `posts`.`user_id` = `users`.`id` AND EXISTS (
		SELECT
		 *
		FROM
		 `roles`
		INNER JOIN `users_roles` ON `roles`.`id` = `users_roles`.`role_id`
		WHERE
		 `users`.`id` = `users_roles`.`user_id` AND `roles`.`name_column` = 'editor' AND `roles`.`deleted_at` IS NULL
	)
)
AND `posts`.`deleted_at` IS NULL

*/
