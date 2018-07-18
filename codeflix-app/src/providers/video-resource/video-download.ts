import {Injectable} from "@angular/core";
import 'rxjs/add/operator/map';
import {VideoResourceProvider} from "./video.resource";
import {Observable} from "rxjs/Observable";
import {VideoModel} from "../sqlite/video.model";
import {VideoPaths} from "./video-paths";
import {Transfer} from "@ionic-native/transfer";

@Injectable()
export class VideoDownload {

    videos: Array<any> = [];

    constructor(public videoResource: VideoResourceProvider,
                public videoModel: VideoModel,
                public videoPaths: VideoPaths,
                public transfer: Transfer) {
    }

    addVideo(videoId): Observable<Object> {
        return this.videoResource.get(videoId)
            .map(video => {
                video.progress = '0%';

                this.videos.push(video);
               return video;
            });
    }

    start(index){
        let fileTransfer = this.transfer.create();
        let video = this.videos[index];
        fileTransfer.download(
            video.file_url,
            this.videoPaths.getFilePath(video)
        ).then((success) => {
            console.log(success);
        }).catch((error) => {
            console.log(error);
        });
        this.insertVideo(this.videos[index]);
    }

    protected insertVideo(video){
        this.videoModel.insert({
            id: video.id,
            title: video.title,
            description: video.description,
            duration: video.duration,
            thumb_url: video.thumb_small_url,
            file_url: video.file_url,
            serie_title: video.serie_title,
            categories_name: JSON.stringify(video.categories_name),
            created_at: video.created_at.replace('T', ' ')
        });
    }
}