<?php

namespace CodeFlix\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use CodeFlix\Models\Category;

/**
 * Class CategoryNameTransformer
 * @package namespace CodeFlix\Transformers;
 */
class CategoryNameTransformer extends TransformerAbstract
{

    /**
     * Transform the \CategoryName entity
     * @param Category|Collection $model
     * @return array
     */
    public function transform(Collection $model)
    {
        return [
            'names' => $model->pluck('category')
        ];
    }
}
