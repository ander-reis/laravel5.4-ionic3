<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Criteria\FindPublishedCompletedCriteria;
use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use CodeFlix\Http\Controllers\Controller;

class VideosController extends Controller
{
    /**
     * @var VideoRepository
     */
    private $videoRepository;

    /**
     * VideosController constructor.
     * @param VideoRepository $videoRepository
     */
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function index()
    {
        $this->videoRepository->pushCriteria(new FindPublishedCompletedCriteria());
        return $this->videoRepository
            ->scopeQuery(function($query){
                return $query->take(10);
            })
            ->paginate();
    }

    /**
     * @param $id
     * @return Video
     * @internal param Video $video
     */
    public function show($id)
    {
        $this->videoRepository->pushCriteria(new FindPublishedCompletedCriteria());
        return $this->videoRepository->find($id);
    }
}
