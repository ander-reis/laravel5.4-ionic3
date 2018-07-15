import {Injectable} from "@angular/core";
import {DBModel} from "./db-model";
import {DB} from "./db";
import {AuthProvider} from "../auth/auth";

@Injectable()
export class VideoModel extends DBModel {

    protected table = 'videos';

    constructor(public db: DB, public auth: AuthProvider) {
        super(db);
    }

    insert(params: Object): Promise<any> {
        return this.auth.user().then((user) => {
            (<any>params).user_id = (<any>user).id;
            return super.insert(params);
        });
    }
}