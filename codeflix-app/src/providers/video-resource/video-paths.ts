import {Injectable} from "@angular/core";
import {AppConfigProvider} from "../app-config/app-config";
import md5 from 'crypto-md5';

@Injectable()
export class VideoPaths {

    private videosDir = 'videos';
    private videosPath;

    constructor(public appConfig: AppConfigProvider) {
        this.videosPath = `${this.appConfig.getAppFilePath()}/${this.videosDir}`;
    }


    getFilePath(video) {
        return `${this.videosPath}/${video.id}/${md5(video.title, 'hex')}.mp4`;
    }

    getThumbPath(video) {
        return `${this.videosPath}/${video.id}/${md5(video.title, 'hex')}.jpg`;
    }

}