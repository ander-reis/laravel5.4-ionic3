import {Injectable} from "@angular/core";
import {AppConfigProvider} from "../app-config/app-config";
import {VideoResourceProvider} from "./video.resource";
import {VideoController} from "./video.controller";
import {VideoAdapter} from "./video.adapter";

@Injectable()
export class VideoFactory {

    constructor(public appConfig: AppConfigProvider,
                public videoResource: VideoResourceProvider,
                public videoController: VideoController) {
    }

    get(): VideoAdapter {
        return this.appConfig.getOff() ? this.videoController : this.videoResource;
    }
}