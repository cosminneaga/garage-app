class Pagination {
    constructor(page, element) {
        this.page = page;
        this.element = element;
    }

    construct(urlObj) {
        for (const [key, url] of Object.entries(urlObj)) {
            const li = document.createElement("li");
            li.appendChild(this.generateNumberButton(url, key, this.page == key ? true : false));
            this.element.appendChild(li);
        }
    }

    generateNumberButton(url, number, active = false) {
        const a = document.createElement("a");
        a.href = url;
        a.className = "border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading box-border flex h-9 w-9 items-center justify-center border text-sm font-medium focus:outline-none";
        a.innerText = number;

        if (active) {
            a.className += 'text-gray-100 bg-brand-softer box-border';
        } else {
            a.className += 'text-body bg-neutral-secondary-medium';
        }

        return a;
    }

    generateIntermediaryButton() {
        const a = document.createElement("a");
        a.href = "#";
        a.innerText = "...";
        a.className = "border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading box-border flex h-9 w-9 items-center justify-center border text-sm font-medium focus:outline-none text-body bg-neutral-secondary-medium text-body bg-neutral-secondary-medium";

        return a;
    }
}

window.Pagination = Pagination;


/**
 * 1 2 ... 35 36
 * 1 2 ... 7 ... 35 36
 */

/**
 * if (pageKeys.length >= 6 && !['1', '2', pageKeys[pageKeys.length - 2], pageKeys[pageKeys.length - 1]].includes(key)) {
                    if (key == 3) {
                        const li = document.createElement("li");
                        const a = document.createElement("a");
                        a.className = "border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading box-border flex h-9 w-9 items-center justify-center border text-sm font-medium focus:outline-none "
                        a.href = "#";
                        a.innerText = "...";
                        li.appendChild(a);
                        numberContainer.appendChild(li);
                    }

                    continue;
                }
 */
