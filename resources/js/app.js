const modal = document.querySelector("#website-modal");
const form = document.querySelector("#website-form");
const websiteList = document.querySelector("#website-list");

document.querySelectorAll('input[type="file"]').forEach((input) => {
    input.addEventListener("change", () => {
        const label = input.closest("label")?.querySelector("[data-file-name]");
        if (label) label.textContent = input.files?.[0]?.name || "Pilih file";
        input.closest("label")?.classList.toggle("has-file", Boolean(input.files?.length));
    });
});

const compressImage = (file) => new Promise((resolve, reject) => {
    if (!file.type.startsWith("image/") || file.size <= 900 * 1024) {
        resolve(file);
        return;
    }

    const image = new Image();
    const objectUrl = URL.createObjectURL(file);
    image.onload = () => {
        const scale = Math.min(1, 1600 / Math.max(image.width, image.height));
        const canvas = document.createElement("canvas");
        canvas.width = Math.max(1, Math.round(image.width * scale));
        canvas.height = Math.max(1, Math.round(image.height * scale));
        canvas.getContext("2d").drawImage(image, 0, 0, canvas.width, canvas.height);
        canvas.toBlob((blob) => {
            URL.revokeObjectURL(objectUrl);
            if (!blob) {
                reject(new Error("Gambar tidak dapat dikompres."));
                return;
            }
            resolve(new File([blob], file.name.replace(/\.[^.]+$/, ".jpg"), { type: "image/jpeg", lastModified: Date.now() }));
        }, "image/jpeg", 0.78);
    };
    image.onerror = () => {
        URL.revokeObjectURL(objectUrl);
        reject(new Error("Gambar tidak dapat dibaca."));
    };
    image.src = objectUrl;
});

const builderForm = document.querySelector(".builder-form");
if (document.querySelector(".admin-shell")) {
    window.setInterval(() => {
        if (!document.hidden) window.location.reload();
    }, 15000);
}
builderForm?.addEventListener("submit", async (event) => {
    event.preventDefault();
    const submitButton = builderForm.querySelector('button[type="submit"]');
    const status = document.querySelector("[data-upload-status]");
    if (submitButton) submitButton.disabled = true;
    if (status) status.textContent = "Menyiapkan foto...";

    try {
        const fileInputs = [...builderForm.querySelectorAll('input[type="file"]')];
        await Promise.all(fileInputs.map(async (input) => {
            const file = input.files?.[0];
            if (!file) return;
            const compressed = await compressImage(file);
            const transfer = new DataTransfer();
            transfer.items.add(compressed);
            input.files = transfer.files;
        }));
        if (status) status.textContent = "Foto siap diunggah.";
        HTMLFormElement.prototype.submit.call(builderForm);
    } catch (error) {
        if (submitButton) submitButton.disabled = false;
        if (status) status.textContent = error.message;
    }
});
const closeModal = () => {
    modal?.classList.remove("open");
    modal?.setAttribute("aria-hidden", "true");
};

document.querySelectorAll("[data-open-modal]").forEach((button) =>
    button.addEventListener("click", () => {
        modal.classList.add("open");
        modal.setAttribute("aria-hidden", "false");
        document.querySelector("#site-name")?.focus();
    }),
);
document
    .querySelectorAll("[data-close-modal]")
    .forEach((button) => button.addEventListener("click", closeModal));
modal?.addEventListener("click", (event) => {
    if (event.target === modal) closeModal();
});

form?.addEventListener("submit", (event) => {
    event.preventDefault();
    const name = form.elements["site-name"].value.trim();
    const template = form.elements["site-template"].value;
    const initials = name
        .split(/\s+/)
        .map((word) => word[0])
        .join("")
        .slice(0, 2)
        .toUpperCase();
    const slug =
        name
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, "")
            .slice(0, 24) || "websitebaru";
    if (!websiteList) {
        form.reset();
        closeModal();
        return;
    }
    const row = document.createElement("tr");
    row.innerHTML = `<td><div class="website-name"><span class="site-thumb thumb-slate">${initials}</span><span><strong>${name}</strong><small>${slug}.framefolk.site</small></span></div></td><td>Admin utama</td><td>${template}</td><td><span class="status draft">● Draft</span></td><td><button class="more-button" title="Opsi website">•••</button></td>`;
    websiteList.prepend(row);
    form.reset();
    closeModal();
});

const pageTitle = document.querySelector(".breadcrumb strong");
document.querySelectorAll(".nav-item[data-page]").forEach((item) =>
    item.addEventListener("click", () => {
        document
            .querySelectorAll(".nav-item")
            .forEach((navItem) => navItem.classList.remove("active"));
        item.classList.add("active");
        document
            .querySelectorAll(".page-view")
            .forEach((view) =>
                view.classList.toggle(
                    "hidden-view",
                    view.id !== item.dataset.page,
                ),
            );
        if (pageTitle)
            pageTitle.textContent = item.textContent
                .trim()
                .replace(/\s+\d+$/, "");
    }),
);

let logoClicks = 0;
let logoTimer;
document.querySelector(".brand")?.addEventListener("click", (event) => {
    event.preventDefault();
    logoClicks += 1;
    clearTimeout(logoTimer);
    logoTimer = setTimeout(() => {
        logoClicks = 0;
    }, 1200);
    if (logoClicks === 5) {
        document.querySelector("#tree-easter-egg")?.classList.add("found");
        logoClicks = 0;
    }
});
