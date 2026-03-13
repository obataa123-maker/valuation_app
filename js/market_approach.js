function maNum(v) {
  v = String(v ?? '').replace(/,/g, '').trim();
  const n = parseFloat(v);
  return isNaN(n) ? 0 : n;
}

function maFmt(n, d = 0) {
  n = Number(n || 0);
  return n.toLocaleString('en-US', {
    minimumFractionDigits: d,
    maximumFractionDigits: d
  });
}

function maGetVal(id) {
  const el = document.getElementById(id);
  if (!el) return '';
  if ('value' in el) return el.value;
  return el.textContent || '';
}

function maGetNum(id) {
  return maNum(maGetVal(id));
}

function maSetText(id, value) {
  const el = document.getElementById(id);
  if (el) el.textContent = value;
}

function maSetLink(id, url, text) {
  const el = document.getElementById(id);
  if (!el) return;
  el.href = url || '#';
  el.textContent = text || '-';
}

function fillMarketAproachTable() {
  const comps = [
    {
      idx: 1,
      link: maGetVal('comp1_link'),
      linkText: maGetVal('comp1_link_text') || 'Жишиг №1',
      phone: maGetVal('comp1_phone'),
      location: maGetVal('comp1_location'),
      floor: maGetVal('comp1_floor'),
      areaText: maGetVal('comp1_area'),
      quality: maGetVal('comp1_quality'),
      equip: maGetVal('comp1_equip'),
      year: maGetVal('comp1_year'),
      price: maGetNum('comp1_price'),
      area: maGetNum('comp1_area')
    },
    {
      idx: 2,
      link: maGetVal('comp2_link'),
      linkText: maGetVal('comp2_link_text') || 'Жишиг №2',
      phone: maGetVal('comp2_phone'),
      location: maGetVal('comp2_location'),
      floor: maGetVal('comp2_floor'),
      areaText: maGetVal('comp2_area'),
      quality: maGetVal('comp2_quality'),
      equip: maGetVal('comp2_equip'),
      year: maGetVal('comp2_year'),
      price: maGetNum('comp2_price'),
      area: maGetNum('comp2_area')
    },
    {
      idx: 3,
      link: maGetVal('comp3_link'),
      linkText: maGetVal('comp3_link_text') || 'Жишиг №3',
      phone: maGetVal('comp3_phone'),
      location: maGetVal('comp3_location'),
      floor: maGetVal('comp3_floor'),
      areaText: maGetVal('comp3_area'),
      quality: maGetVal('comp3_quality'),
      equip: maGetVal('comp3_equip'),
      year: maGetVal('comp3_year'),
      price: maGetNum('comp3_price'),
      area: maGetNum('comp3_area')
    }
  ];

  let totalWeighted = 0;

  comps.forEach(c => {
    maSetLink(`ma_src_link_${c.idx}`, c.link, c.linkText);
    maSetText(`ma_phone_${c.idx}`, c.phone || '-');
    maSetText(`ma_location_${c.idx}`, c.location || '-');
    maSetText(`ma_floor_${c.idx}`, c.floor || '-');
    maSetText(`ma_area_${c.idx}`, c.areaText || '-');
    maSetText(`ma_quality_${c.idx}`, c.quality || '-');
    maSetText(`ma_equip_${c.idx}`, c.equip || '-');
    maSetText(`ma_year_${c.idx}`, c.year || '-');

    maSetText(`ma_price_${c.idx}`, maFmt(c.price));
    maSetText(`ma_total_area_${c.idx}`, maFmt(c.area, 2));

    const unitPrice = c.area > 0 ? (c.price / c.area) : 0;
    maSetText(`ma_unit_price_${c.idx}`, maFmt(unitPrice, 2));

    const i1 = maGetNum(`ma_i1_${c.idx}`) || 1;
    const i2 = maGetNum(`ma_i2_${c.idx}`) || 1;
    const i4 = maGetNum(`ma_i4_${c.idx}`) || 1;
    const i5 = maGetNum(`ma_i5_${c.idx}`) || 1;
    const i6 = maGetNum(`ma_i6_${c.idx}`) || 1;
    const i7 = maGetNum(`ma_i7_${c.idx}`) || 1;

    const adjCoef = i1 * i2 * i4 * i5 * i6 * i7;
    maSetText(`ma_adj_coef_${c.idx}`, maFmt(adjCoef, 2));

    const adjUnitPrice = unitPrice * adjCoef;
    maSetText(`ma_adj_unit_price_${c.idx}`, maFmt(adjUnitPrice, 2));

    const w = maGetNum(`ma_w_${c.idx}`);
    const weighted = adjUnitPrice * w;
    maSetText(`ma_weighted_${c.idx}`, maFmt(weighted, 2));

    totalWeighted += weighted;
  });

  maSetText('ma_market_avg_price', maFmt(totalWeighted, 2));

  const g = maGetNum('ma_subject_coef') || 1;
  const finalValue = totalWeighted * g;
  maSetText('ma_final_unit_value', maFmt(finalValue, 2));
}

function bindMarketAproachEvents() {
  const ids = [
    'ma_i1_1','ma_i1_2','ma_i1_3',
    'ma_i2_1','ma_i2_2','ma_i2_3',
    'ma_i4_1','ma_i4_2','ma_i4_3',
    'ma_i5_1','ma_i5_2','ma_i5_3',
    'ma_i6_1','ma_i6_2','ma_i6_3',
    'ma_i7_1','ma_i7_2','ma_i7_3',
    'ma_w_1','ma_w_2','ma_w_3',
    'ma_subject_coef',

    'comp1_link','comp1_link_text','comp1_phone','comp1_location','comp1_floor','comp1_area','comp1_quality','comp1_equip','comp1_year','comp1_price',
    'comp2_link','comp2_link_text','comp2_phone','comp2_location','comp2_floor','comp2_area','comp2_quality','comp2_equip','comp2_year','comp2_price',
    'comp3_link','comp3_link_text','comp3_phone','comp3_location','comp3_floor','comp3_area','comp3_quality','comp3_equip','comp3_year','comp3_price'
  ];

  ids.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', fillMarketAproachTable);
      el.addEventListener('change', fillMarketAproachTable);
    }
  });
}

document.addEventListener('DOMContentLoaded', function () {
  bindMarketAproachEvents();
  fillMarketAproachTable();
});