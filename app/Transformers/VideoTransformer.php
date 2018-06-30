<?php

namespace CodeFlix\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFlix\Models\Video;

/**
 * Class VideoTransformer
 * @package namespace CodeFlix\Transformers;
 */
class VideoTransformer extends TransformerAbstract
{
    //include obrigatorio -> sempre var ser serializado
    //include facultativo -> soment se nós requisitarmos será serializado

    //protected $defaultIncludes = ['serie']; //obrigatorio
    protected $availableIncludes = [
        'serie',
        'serie_title',
        'categories',
        'categories_name',
    ]; //facultativo
    /**
     * exemplo: localhost:8000/api/videos/1?include=serie,categories
     */

    /**
     * Transform the \Video entity
     * @param Video $model
     *
     * @return array
     */
    public function transform(Video $model)
    {
        return [
            'id' => (int)$model->id,
            'title' => $model->title,
            'descripton' => $model->description,
            'thumb_small_url' => $model->thumb_small_asset,
            'file_url' => $model->file_asset,
            'created_at' => $model->created_at->format(\DateTime::ISO8601),
            'updated_at' => $model->updated_at->format(\DateTime::ISO8601)
        ];
    }

    public function includeSerie(Video $model)
    {
        if(!$model->serie){
            return null;
        }
        return $this->item($model->serie, new SerieTransformer());
    }

    public function includeSerieTitle(Video $model)
    {
        if(!$model->serie){
            return null;
        }
        return $this->item($model->serie, new SerieTitleTransformer());
    }

    public function includeCategories(Video $model)
    {
        return $this->collection($model->categories, new CategoryTransformer());
    }

    public function includeCategoriesName(Video $model)
    {
        return $this->item($model->categories, new CategoryNameTransformer());
    }
}
