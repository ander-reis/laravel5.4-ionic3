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

    async latest(page, search){
        this.initQueryBuilder();
        let user = await this.auth.user();
        let where = 'user_id = ? AND (title like ? OR description like ? OR serie_title like ? OR categories_name like ?)';
        let searchLike = `%${search}%`;
        this.qb = this.qb.select().where(where, (<any>user).id, searchLike, searchLike, searchLike, searchLike)
            .order('created_at');
        return super.paginate(page);
    }
}