import {Injectable} from "@angular/core";
import 'rxjs/add/operator/map';
import {VideoResourceProvider} from "./video.resource";
import {Observable} from "rxjs/Observable";

@Injectable()
export class VideoDownload {

    videos: Array<any> = [];

    constructor(public videoResource: VideoResourceProvider) {
    }

    addVideo(videoId): Observable<Object> {
        return this.videoResource.get(videoId)
            .map(video => {
                this.videos.push(video);
                console.log(this.videos);
               return video;
            });
    }
}