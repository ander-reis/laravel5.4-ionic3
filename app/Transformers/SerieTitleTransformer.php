<?php

namespace CodeFlix\Transformers;

use CodeFlix\Models\Serie;
use League\Fractal\TransformerAbstract;

/**
 * Class SerieTitleTransformer
 * @package namespace CodeFlix\Transformers;
 */
class SerieTitleTransformer extends TransformerAbstract
{

    /**
     * Transform the \SerieTitle entity
     * @param \SerieTitle $model
     *
     * @return array
     */
    public function transform(Serie $model)
    {
        return [
            'title' => $model->title
        ];
    }
}
