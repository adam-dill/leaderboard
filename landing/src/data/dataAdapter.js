export default class DataAdapter {

    /** The api url. */
    _url = "http://leaderboards.adamdill.com";


    async getGames() {
        return await fetch(this._url + "/games");
    }

    async getGameScores(id) {
        return await fetch(this._url + "/scores/" + id);
    }
}