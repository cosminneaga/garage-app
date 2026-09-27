export default class ServerRequest {
    static async query(url, body = { search: "" }) {
        const response = await fetch(url, {
            method: "QUERY",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify(body),
        });
        return await response.json();
    }

    static async get(url) {
        const response = await fetch(url);
        return await response.json();
    }
}
