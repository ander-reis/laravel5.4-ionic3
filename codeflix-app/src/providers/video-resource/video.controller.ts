import 'rxjs/add/operator/map';
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
//import {Env} from "../../models/env";
import {VideoAdapter} from "./video.adapter";
import {VideoModel} from "../sqlite/video.model";

//declare var ENV: Env

@Injectable()
export class VideoController implements VideoAdapter{

    constructor(public videoModel: VideoModel) {
    }

    latest(page: number, search: string): Observable<any>{
        return Observable.create(observer => {

        });
    }

    get(id: number): Observable<any>{
        return Observable.create(observer => {

        });
    }
}