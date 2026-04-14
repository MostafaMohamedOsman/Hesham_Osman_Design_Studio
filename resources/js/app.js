import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    function setupGallery({
        gallerySelector,
        fileInputSelector,
        hiddenInputsSelector,
    }) {
        const gallery = document.querySelector(gallerySelector);
        const input = document.querySelector(fileInputSelector);
        const hiddenContainer = hiddenInputsSelector
            ? document.querySelector(hiddenInputsSelector)
            : null;
        if (!gallery) return;

        // Build items array from existing DOM children (preserve existing markup)
        let items = Array.from(gallery.querySelectorAll(".img-item")).map(
            (el) => ({
                el,
                type: el.dataset.type || (el.dataset.id ? "existing" : "new"),
                id: el.dataset.id ? parseInt(el.dataset.id) : null,
                filename: el.dataset.filename || null,
                file: null,
                uid:
                    el.dataset.uid ||
                    "existing-" +
                        (el.dataset.id || Math.random().toString(36).slice(2)),
            }),
        );

        let newUid = 0;

        function rebuildHidden() {
            if (!hiddenContainer) return;
            hiddenContainer.innerHTML = "";
            let newIndex = 0;
            items.forEach((it) => {
                const inputEl = document.createElement("input");
                inputEl.type = "hidden";
                inputEl.name = "image_order_mixed[]";
                if (it.type === "existing") {
                    inputEl.value = "existing:" + it.id;
                } else {
                    inputEl.value = "new:" + newIndex++;
                }
                hiddenContainer.appendChild(inputEl);
            });
        }

        function updateFileInput() {
            if (!input) return;
            const dt = new DataTransfer();
            items.forEach((it) => {
                if (it.type === "new" && it.file) dt.items.add(it.file);
            });
            input.files = dt.files;
        }

        function refreshDomOrder() {
            gallery.innerHTML = "";
            items.forEach((it) => gallery.appendChild(it.el));
            rebuildHidden();
            updateFileInput();
        }

        function moveItem(from, to) {
            if (to < 0 || to >= items.length) return;
            const [item] = items.splice(from, 1);
            items.splice(to, 0, item);
            refreshDomOrder();
        }

        function removeItem(index) {
            if (index < 0 || index >= items.length) return;
            const it = items[index];
            // For existing images, mark them for deletion (append hidden input)
            if (it.type === "existing") {
                const deletedContainer = document.querySelector(
                    "#deleted-image-inputs",
                );
                if (deletedContainer) {
                    const delInput = document.createElement("input");
                    delInput.type = "hidden";
                    delInput.name = "images_to_delete[]";
                    delInput.value = it.id;
                    deletedContainer.appendChild(delInput);
                }
            }
            items.splice(index, 1);
            refreshDomOrder();
        }

        // Delegate click handlers for move and remove
        gallery.addEventListener("click", (e) => {
            const btn = e.target.closest("button");
            if (!btn) return;
            const itemEl = btn.closest(".img-item");
            if (!itemEl) return;
            const idx = items.findIndex((i) => i.el === itemEl);
            if (btn.classList.contains("btn-move-left")) moveItem(idx, idx - 1);
            else if (btn.classList.contains("btn-move-right"))
                moveItem(idx, idx + 1);
            else if (
                btn.classList.contains("btn-remove") ||
                btn.classList.contains("btn-mark-delete")
            )
                removeItem(idx);
        });

        // Handle new file selection
        if (input) {
            input.addEventListener("change", function () {
                const files = Array.from(this.files || []);
                files.forEach((file) => {
                    const reader = new FileReader();
                    const uid = "new-" + newUid++;
                    reader.onload = function (ev) {
                        const el = document.createElement("div");
                        el.className = "border rounded p-0 img-item";
                        el.dataset.type = "new";
                        el.dataset.uid = uid;

                        const wrap = document.createElement("div");
                        wrap.style.width = "90px";
                        wrap.style.height = "90px";
                        wrap.style.overflow = "hidden";
                        const img = document.createElement("img");
                        img.src = ev.target.result;
                        img.style.width = "100%";
                        img.style.height = "100%";
                        img.style.objectFit = "cover";
                        wrap.appendChild(img);
                        el.appendChild(wrap);

                        const controls = document.createElement("div");
                        controls.className = "d-flex gap-1 mt-1";
                        const left = document.createElement("button");
                        left.type = "button";
                        left.className =
                            "btn btn-sm btn-secondary btn-move-left";
                        left.innerHTML = '<i class="fas fa-arrow-left"></i>';
                        const right = document.createElement("button");
                        right.type = "button";
                        right.className =
                            "btn btn-sm btn-secondary btn-move-right";
                        right.innerHTML = '<i class="fas fa-arrow-right"></i>';
                        const rem = document.createElement("button");
                        rem.type = "button";
                        rem.className = "btn btn-sm btn-danger btn-remove";
                        rem.innerHTML = '<i class="fas fa-trash"></i>';
                        controls.appendChild(left);
                        controls.appendChild(right);
                        controls.appendChild(rem);
                        el.appendChild(controls);

                        items.push({ el, type: "new", file: file, uid: uid });
                        gallery.appendChild(el);
                        rebuildHidden();
                        updateFileInput();
                    };
                    reader.readAsDataURL(file);
                });
            });
        }

        // Initialize hidden inputs & file input state
        rebuildHidden();
        updateFileInput();
    }

    // Create page gallery
    if (
        document.querySelector("#img-previews") &&
        document.querySelector("#imgs")
    ) {
        setupGallery({
            gallerySelector: "#img-previews",
            fileInputSelector: "#imgs",
            hiddenInputsSelector: "#image-order-inputs",
        });
    }
    // Edit page gallery
    if (document.querySelector("#img-gallery")) {
        setupGallery({
            gallerySelector: "#img-gallery",
            fileInputSelector: "#imgs",
            hiddenInputsSelector: "#image-order-inputs",
        });
    }
});
