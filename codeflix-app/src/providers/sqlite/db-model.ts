import {Injectable} from '@angular/core';
import {DB} from "./db";
import objectValues from 'object.values';
import squel from 'squel';

/*
  Generated class for the DBModel provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export abstract class DBModel {

    protected abstract table;
    protected qb;

    constructor(public db: DB) {
    }

    insert(params: Object): Promise<any> {
        let columns = Object.keys(params);
        columns.map((value) => {
            return `\`${value}\``;
        });
        let tokens = "?,".repeat(columns.length);
        tokens = tokens.substring(0, tokens.length - 1);
        let sql = `INSERT INTO \`${this.table}\` (${columns.join(',')}) VALUES (${tokens})`;

        //console.log(sql);

        return this.db.executeSQL(sql, objectValues(params));
    }

    find(id): Promise<any>{
        let sql = `SELECT * FROM ${this.table} WHERE id = ?`;
        return this.db.executeSQL(sql, [id])
            .then(resultset => {
                return resultset.rows.length ? resultset.rows.item(0) : null;
            }).catch(e => console.log(e));
    }

    findByField(field, value){
        let sql = `SELECT * FROM ${this.table} WHERE \`${field}\` = ?`;
        return this.db.executeSQL(sql, [value]);
    }

    paginate(page, perPage = 15): Promise<any> {
        this.initQueryBuilder();
        let offset = (page - 1) * perPage;
        if (typeof this.qb.VERSION != "undefined") {
            this.qb = this.qb.select();
        }
        this.qb = this.qb.from(this.table).limit(perPage);
        if (offset != 0) {
            this.qb = this.qb.offset(offset);
        }
        let sqlObj = this.qb.toParam();

        console.log(sqlObj.text);
        console.log(sqlObj.values);

        return this.db.executeSQL(sqlObj.text, sqlObj.values)
            .then(resultset => {
                let rows = [];
                for (let i = 0; i < resultset.rows.length; i++) {
                    rows.push(resultset.rows.item(i));
                }
                console.log(rows);
                return rows;
            });
    }

    protected initQueryBuilder(){
        if(!this.qb){
            this.qb = squel;
        }
    }
}
