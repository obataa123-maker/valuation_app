(function () {
    let activeInput = null;

    function stripCommas(v) {
        return String(v || "").replace(/,/g, "").trim();
    }

    function formatNumber(v) {
        if (v === null || v === undefined || v === "") return "";
        const n = Number(v);
        if (!isFinite(n)) return String(v);
        return n.toLocaleString("en-US", {
            maximumFractionDigits: 10
        });
    }

    function sanitizeExpression(expr) {
        expr = stripCommas(expr);
        expr = expr.replace(/%/g, "/100");
        expr = expr.replace(/[^0-9+\-*/().]/g, "");
        return expr;
    }

    function safeEval(expr) {
        const clean = sanitizeExpression(expr);
        if (!clean) return "";
        return Function('"use strict"; return (' + clean + ')')();
    }

    function ensureModal() {
        if (document.getElementById("smartCalcModal")) return;

        const html = `
        <div id="smartCalcModal" class="calc-modal">
          <div id="smartCalcPanel" class="calc-panel">
            <div class="calc-head">
              <span>Тооцоолуур</span>
              <button type="button" class="calc-close" id="smartCalcClose">×</button>
            </div>

            <div class="calc-body">
              <input type="text" id="smartCalcScreen" class="calc-screen" autocomplete="off">
              <div id="smartCalcPreview" class="calc-result-preview"></div>

              <div class="calc-grid">
                <button type="button" class="calc-key op" data-calc="(">(</button>
                <button type="button" class="calc-key op" data-calc=")">)</button>
                <button type="button" class="calc-key op" data-calc="back">⌫</button>
                <button type="button" class="calc-key op" data-calc="clear">C</button>

                <button type="button" class="calc-key" data-calc="7">7</button>
                <button type="button" class="calc-key" data-calc="8">8</button>
                <button type="button" class="calc-key" data-calc="9">9</button>
                <button type="button" class="calc-key op" data-calc="/">÷</button>

                <button type="button" class="calc-key" data-calc="4">4</button>
                <button type="button" class="calc-key" data-calc="5">5</button>
                <button type="button" class="calc-key" data-calc="6">6</button>
                <button type="button" class="calc-key op" data-calc="*">×</button>

                <button type="button" class="calc-key" data-calc="1">1</button>
                <button type="button" class="calc-key" data-calc="2">2</button>
                <button type="button" class="calc-key" data-calc="3">3</button>
                <button type="button" class="calc-key op" data-calc="-">−</button>

                <button type="button" class="calc-key" data-calc="0">0</button>
                <button type="button" class="calc-key" data-calc=".">.</button>
                <button type="button" class="calc-key wide op" data-calc="+">+</button>

                <button type="button" class="calc-key wide" data-calc="%">%</button>
                <button type="button" class="calc-key wide eq" data-calc="equal">=</button>
              </div>
            </div>
          </div>
        </div>`;
        document.body.insertAdjacentHTML("beforeend", html);
    }

    function getModalEls() {
        return {
            modal: document.getElementById("smartCalcModal"),
            panel: document.getElementById("smartCalcPanel"),
            screen: document.getElementById("smartCalcScreen"),
            preview: document.getElementById("smartCalcPreview"),
            closeBtn: document.getElementById("smartCalcClose")
        };
    }

    function updatePreview() {
        const { screen, preview } = getModalEls();
        try {
            const result = safeEval(screen.value);
            preview.textContent = result === "" ? "" : "= " + formatNumber(result);
        } catch (e) {
            preview.textContent = "";
        }
    }

    function openCalculator(inputEl, buttonEl) {
        activeInput = inputEl;
        const { modal, panel, screen } = getModalEls();

        screen.value = stripCommas(inputEl.value || "");
        updatePreview();
        modal.classList.add("show");

        const btnRect = buttonEl.getBoundingClientRect();
        const panelWidth = 320;
        const panelHeight = 360;
        const margin = 10;

        let left = btnRect.right - panelWidth;
        if (left < margin) left = margin;
        if (left + panelWidth > window.innerWidth - margin) {
            left = window.innerWidth - panelWidth - margin;
        }

        let top = btnRect.bottom + 8;
        if (top + panelHeight > window.innerHeight - margin) {
            top = btnRect.top - panelHeight;
        }
        if (top < margin) top = margin;

        panel.style.left = left + "px";
        panel.style.top = top + "px";

        setTimeout(() => screen.focus(), 30);
    }

    function closeCalculator() {
        const { modal } = getModalEls();
        modal.classList.remove("show");
        activeInput = null;
    }

    function insertCalcButton(input) {
        if (!input || input.dataset.calcReady === "1") return;

        const wrap = document.createElement("div");
        wrap.className = "calc-field";

        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "calc-btn";
        btn.innerHTML = "🧮";
        btn.title = "Тооцоолуур";
        btn.setAttribute("aria-label", "Тооцоолуур");
        wrap.appendChild(btn);

        btn.addEventListener("click", function () {
            openCalculator(input, btn);
        });

        input.dataset.calcReady = "1";

input.addEventListener("input", function () {
    let raw = stripCommas(input.value).replace(/[^0-9.\-]/g, "");

    // minus зөвхөн эхэндээ байг
    raw = raw.replace(/(?!^)-/g, "");

    // нэг л цэгтэй байг
    const firstDot = raw.indexOf(".");
    if (firstDot !== -1) {
        raw = raw.slice(0, firstDot + 1) + raw.slice(firstDot + 1).replace(/\./g, "");
    }

    // хэрэглэгч бичиж дуусаагүй завсрын төлөвүүдийг зөвшөөрнө
    if (raw === "" || raw === "-" || raw === "." || raw === "-." || raw.endsWith(".")) {
        input.value = raw;
        return;
    }

    const n = Number(raw);
    if (isFinite(n)) {
        input.value = n.toLocaleString("en-US", {
            maximumFractionDigits: 10
        });
    }
});
    }

    function bindCalcableInputs() {
        document.querySelectorAll("input.calcable").forEach(insertCalcButton);
    }

    function bindModalEvents() {
        document.addEventListener("click", function (e) {
            const key = e.target.closest("[data-calc]");
            if (!key) return;

            const { screen } = getModalEls();
            const action = key.getAttribute("data-calc");

            if (action === "clear") {
                screen.value = "";
                updatePreview();
                return;
            }

            if (action === "back") {
                screen.value = screen.value.slice(0, -1);
                updatePreview();
                return;
            }

            if (action === "equal") {
                try {
                    const result = safeEval(screen.value);
                    if (activeInput && result !== "") {
                        activeInput.value = formatNumber(result);
                        activeInput.dispatchEvent(new Event("input", { bubbles: true }));
                        activeInput.dispatchEvent(new Event("change", { bubbles: true }));
                    }
                    closeCalculator();
                } catch (e2) {
                    alert("Тооцоолол буруу байна");
                }
                return;
            }

            screen.value += action;
            updatePreview();
        });

        const { modal, screen, closeBtn } = getModalEls();

        screen.addEventListener("input", updatePreview);

        closeBtn.addEventListener("click", closeCalculator);

        modal.addEventListener("click", function (e) {
            if (e.target === modal) closeCalculator();
        });

        document.addEventListener("keydown", function (e) {
            if (!modal.classList.contains("show")) return;

            if (e.key === "Escape") {
                closeCalculator();
                return;
            }

            if (e.key === "Enter") {
                e.preventDefault();
                try {
                    const result = safeEval(screen.value);
                    if (activeInput && result !== "") {
                        activeInput.value = formatNumber(result);
                        activeInput.dispatchEvent(new Event("input", { bubbles: true }));
                        activeInput.dispatchEvent(new Event("change", { bubbles: true }));
                    }
                    closeCalculator();
                } catch (err) {
                    alert("Тооцоолол буруу байна");
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        ensureModal();
        bindCalcableInputs();
        bindModalEvents();
    });
})();