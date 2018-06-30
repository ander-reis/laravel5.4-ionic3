<?php

namespace CodeFlix\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindPublishedCompletedCriteria
 * @package namespace CodeFlix\Criteria;
 */
class FindPublishedCompletedCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('published', 1)
            ->where('completed', 1);
    }
}
