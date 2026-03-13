function numVal(id) {
    const el = document.getElementById(id);
    if (!el) return 0;
    const v = (el.value || el.textContent || '').toString().replace(/,/g, '').trim();
    const n = parseFloat(v);
    return isNaN(n) ? 0 : n;
}

function setVal(id, value, decimals = 2) {
    const el = document.getElementById(id);
    if (!el) return;

    let out = '';
    if (value !== '' && value !== null && value !== undefined && !isNaN(value)) {
        out = Number(value).toLocaleString('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    if ('value' in el) {
        el.value = out;
    } else {
        el.textContent = out;
    }
}

function calcRow(i) {
    const A   = numVal(`ma_a_${i}`);
    const TA1 = numVal(`ma_ta1_${i}`);
    const TA2 = numVal(`ma_ta2_${i}`);
    const TA3 = numVal(`ma_ta3_${i}`);
    const TA4 = numVal(`ma_ta4_${i}`);
    const TA5 = numVal(`ma_ta5_${i}`);
    const C   = numVal(`ma_c_${i}`);

    const B1 = A - TA1;
    const B2 = B1 - TA2;
    const B3 = B2 - TA3;
    const B4 = B3 - TA4;
    const B5 = B4 - TA5;
    const Bfinal = B5;

    setVal(`ma_b_ta1_${i}`, B1, 2);
    setVal(`ma_b_ta2_${i}`, B2, 2);
    setVal(`ma_b_ta3_${i}`, B3, 2);
    setVal(`ma_b_ta4_${i}`, B4, 2);
    setVal(`ma_b_ta5_${i}`, B5, 2);
    setVal(`ma_b_final_${i}`, Bfinal, 2);

    const D = C !== 0 ? (Bfinal / C) : 0;
    setVal(`ma_d_${i}`, D, 2);

    const I1 = numVal(`ma_i1_${i}`);
    const I2 = numVal(`ma_i2_${i}`);
    const I4 = numVal(`ma_i4_${i}`);
    const I5 = numVal(`ma_i5_${i}`);
    const I6 = numVal(`ma_i6_${i}`);
    const I7 = numVal(`ma_i7_${i}`);

    const Ij = I1 * I2 * I4 * I5 * I6 * I7;
    setVal(`ma_ij_${i}`, Ij, 4);

    const Ej = D * Ij;
    setVal(`ma_ej_${i}`, Ej, 2);

    const W = numVal(`ma_w_${i}`);
    const Fj = Ej * W;
    setVal(`ma_fj_${i}`, Fj, 2);

    return { Fj };
}

function calcAllMarketApproach() {
    const r1 = calcRow(1);
    const r2 = calcRow(2);
    const r3 = calcRow(3);

    const P = r1.Fj + r2.Fj + r3.Fj;
    setVal('ma_p', P, 2);

    const G = numVal('ma_g');
    const V = G * P;
    setVal('ma_v', V, 2);
}

document.addEventListener('input', function (e) {
    if (e.target.closest('.market-approach-table')) {
        calcAllMarketApproach();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    calcAllMarketApproach();
});