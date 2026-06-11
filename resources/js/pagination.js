class Pagination {
    constructor(current, urlsObj) {
        this.current = current;
        this.urls = Object.entries(urlsObj);
        this.total = this.urls.length;
    }

    construct(nodeParentEl) {
        const pages = this.generate();
        for (const page of pages) {
            const li = document.createElement("li");
            const a = document.createElement("a");
            a.href = page.url;
            a.innerText = page.text;
            a.className =
                "border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading box-border flex h-9 w-9 items-center justify-center border text-sm font-medium focus:outline-none";

            if (page.active) {
                a.className += " text-gray-100 bg-brand-softer box-border";
            } else {
                a.className += " text-body bg-neutral-secondary-medium";
            }

            li.appendChild(a);
            nodeParentEl.appendChild(li);
        }
    }

    generate() {
        if (this.total <= 6) {
            return this.urls.map(([number, url]) => ({
                text: number,
                url: url,
                active: parseInt(number) === this.current ? true : false,
            }));
        }

        let once = 0;
        const result = [];
        for (const [number, url] of this.urls) {
            const num = parseInt(number);
            if ([1, 2, this.total - 1, this.total].includes(num)) {
                result.push({
                    text: num,
                    url: url,
                    active: num === this.current ? true : false,
                });
            }

            if (once <= 0 && this.current === num && ![1, 2, this.total - 1, this.total].includes(num)) {
                result.push({
                    text: num,
                    url: url,
                    active: num === this.current ? true : false,
                });
                continue;
            }

            if (this.current === 3 && num === 3) {
                result.push({
                    text: num,
                    url: url,
                    active: num === this.current ? true : false,
                });
                result.push({
                    text: "...",
                    url: "#",
                    active: false,
                });
            }

            if (this.current === this.total - 2 && num === this.total - 2) {
                result.push({
                    text: "...",
                    url: "#",
                    active: false,
                });
                result.push({
                    text: num,
                    url: url,
                    active: num === this.current ? true : false,
                });
            }
        }

        if (result.length === 4) {
            result.splice(2, 0, { text: "...", url: "#", active: false });
        }

        return result;
    }
}

window.Pagination = Pagination;
