import {Injectable, NgZone} from "@angular/core";
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
                public transfer: Transfer,
                public zone: NgZone) {
    }

    addVideo(videoId): Observable<Object> {
        return this.videoResource.get(videoId)
            .map(video => {
                video.progress = '0%';
                this.videos.push(video);
               return video;
            });
    }

    start(index): Promise<any> {
        let fileTransfer = this.transfer.create();
        let video = this.videos[index];

        //progressbar
        fileTransfer.onProgress((event: ProgressEvent) => {
            if(event.lengthComputable){
                this.zone.run(() => {
                    let progress = (event.loaded / event.total) * 100;
                    progress = Math.ceil(progress);
                    video.progress = `${progress}%`;
                });
            }
        });

        return fileTransfer.download(
            video.file_url,
            // 'http://www.sample.videos.com/video/mp4/720/big_buck_bunny_720p_10mb.mp4',
            //'http://www.videos.com/play/M34350639-1/popular_videos/untitled.html',
            this.videoPaths.getFilePath(video)
        ).then((success) => {
            console.log(success);
            return this.transferThumb(video);
        }).then(() => {
            return this.insertVideo(this.videos[index]);
        }).catch((error) => {
            console.log(error);
        });
    }

    protected transferThumb(video) {
        let fileTransfer = this.transfer.create();
        return fileTransfer.download(
            video.thumb_small_url,
            this.videoPaths.getThumbPath(video)
        );
    }

    protected insertVideo(video){
        return this.videoModel.insert({
            id: video.id,
            title: video.title,
            description: video.description,
            duration: video.duration,
            thumb_url: this.videoPaths.getThumbPath(video),
            file_url: this.videoPaths.getFilePath(video),
            serie_title: video.serie_title,
            categories_name: JSON.stringify(video.categories_name),
            created_at: video.created_at.replace('T', ' ')
        });
    }
}