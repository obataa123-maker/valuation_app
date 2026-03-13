function num(v){
  v = String(v || "").replace(/,/g, "").trim();
  var n = parseFloat(v);
  return isNaN(n) ? 0 : n;
}

function fmt(n){
  return Number(n || 0).toLocaleString('en-US');
}

function getMixedValue(id){
  var el = document.getElementById(id);
  if(!el) return 0;

  if(el.tagName === "SPAN" || el.tagName === "DIV"){
    return num(el.textContent);
  }

  return num(el.value);
}

function setMixedValue(id, value){
  var el = document.getElementById(id);
  if(!el) return;

  if(el.tagName === "SPAN" || el.tagName === "DIV"){
    el.textContent = fmt(value);
  } else {
    el.value = fmt(value);
  }
}

function syncIncomeInputs(){
  var utas = getMixedValue("utas");
  var mean = getMixedValue("rent_mean");
  var result = utas * mean;

  // utas -> inc_A
  var incAEl = document.getElementById("inc_A");
  if(incAEl){
    if(incAEl.tagName === "SPAN" || incAEl.tagName === "DIV"){
      incAEl.textContent = fmt(utas);
    } else {
      incAEl.value = utas;
    }
  }

  // utas * rent_mean -> inc_B
  var incBEl = document.getElementById("inc_B");
  if(incBEl){
    if(incBEl.tagName === "SPAN" || incBEl.tagName === "DIV"){
      incBEl.textContent = fmt(result);
    } else {
      incBEl.value = result;
    }
  }

  incomeCalc();
}

function incomeCalc(){
  let A   = getMixedValue("inc_A");
  let B   = getMixedValue("inc_B");

  let G   = getMixedValue("inc_G");
  let D   = getMixedValue("inc_D");
  let E   = getMixedValue("inc_E");

  let Z1  = getMixedValue("inc_Z1");
  let Z2  = getMixedValue("inc_Z2");
  let Z3  = getMixedValue("inc_Z3");
  let Z4  = getMixedValue("inc_Z4");
  let Z5  = getMixedValue("inc_Z5");
  let Z6  = getMixedValue("inc_Z6");

  let KZ  = getMixedValue("inc_KZ");
  let ZEE = getMixedValue("inc_ZEE");

  let R   = getMixedValue("inc_R");

  // B нь сарын орлого тул *12
  let V   = (B || 0) * 12;
  let BO  = (V || 0) - (G || 0) - (D || 0) + (E || 0);
  let BNO = BO;

  let NZ  = (Z1 || 0) + (Z2 || 0) + (Z3 || 0) + (Z4 || 0) + (Z5 || 0) + (Z6 || 0);
  let NZA = (KZ || 0) + (ZEE || 0);

  // Татварын өмнөх ашиг
  let TOA = BO - NZ - KZ - ZEE;

  let T = TOA > 0 ? TOA * 0.1 : 0;
  let TDA = TOA - T;
  let CMU = TDA + Z5;
  let PV  = CMU;
  let P   = R ? PV / R : 0;

  setMixedValue("inc_V", V);
  setMixedValue("inc_BO", BO);
  setMixedValue("inc_BNO", BNO);
  setMixedValue("inc_NZ", NZ);
  setMixedValue("inc_TOA", TOA);
  setMixedValue("inc_TAX", T);
  setMixedValue("inc_TDA", TDA);
  setMixedValue("inc_CMU", CMU);
  setMixedValue("inc_PV", PV);
  setMixedValue("inc_P", P);

  // Хэрвээ тусдаа NZA харуулах талбар байвал
  setMixedValue("inc_NZA", NZA);
}

document.addEventListener("input", function(e){
  if(
    e.target &&
    (
      e.target.classList.contains("income-input") ||
      e.target.id === "utas" ||
      e.target.id === "inc_G" ||
      e.target.id === "inc_D" ||
      e.target.id === "inc_E" ||
      e.target.id === "inc_Z1" ||
      e.target.id === "inc_Z2" ||
      e.target.id === "inc_Z3" ||
      e.target.id === "inc_Z4" ||
      e.target.id === "inc_Z5" ||
      e.target.id === "inc_Z6" ||
      e.target.id === "inc_KZ" ||     // <-- нэмсэн
      e.target.id === "inc_ZEE" ||    // <-- нэмсэн
      e.target.id === "inc_R"
    )
  ){
    if(e.target.id === "utas"){
      syncIncomeInputs();
    } else {
      incomeCalc();
    }
  }
});

document.addEventListener("change", function(e){
  if(
    e.target &&
    (
      e.target.classList.contains("income-input") ||
      e.target.id === "inc_G" ||
      e.target.id === "inc_D" ||
      e.target.id === "inc_E" ||
      e.target.id === "inc_Z1" ||
      e.target.id === "inc_Z2" ||
      e.target.id === "inc_Z3" ||
      e.target.id === "inc_Z4" ||
      e.target.id === "inc_Z5" ||
      e.target.id === "inc_Z6" ||
      e.target.id === "inc_KZ" ||     // <-- нэмсэн
      e.target.id === "inc_ZEE" ||    // <-- нэмсэн
      e.target.id === "inc_R"
    )
  ){
    incomeCalc();
  }
});

document.addEventListener("DOMContentLoaded", function(){
  syncIncomeInputs();

  var rentMeanEl = document.getElementById("rent_mean");
  if(rentMeanEl){
    var observer = new MutationObserver(function(){
      syncIncomeInputs();
    });

    observer.observe(rentMeanEl, {
      childList: true,
      characterData: true,
      subtree: true
    });
  }
});

function syncSelectedCapRateToIncomeR(){
  var selected = document.querySelector('input[name="cap_method"]:checked');
  var incREl = document.getElementById("inc_R");
  if(!selected || !incREl) return;

  var sourceId = "";
  if(selected.value === "ring") sourceId = "ring_cap_rate";
  if(selected.value === "inwood") sourceId = "inwood_cap_rate";
  if(selected.value === "hoskold") sourceId = "hoskold_cap_rate";

  var src = document.getElementById(sourceId);
  if(!src) return;

  // cap rate input дээр 13.4567 гэсэн % утга байгаа бол 0.134567 болгоно
  var val = num(src.value) / 100;

  incREl.value = val ? val.toFixed(6) : "";

  // realtime income valuation дахин бодно
  if(typeof incomeCalc === "function"){
    incomeCalc();
  }
}

document.addEventListener("change", function(e){
  if(e.target && e.target.classList && e.target.classList.contains("cap-method-radio")){
    syncSelectedCapRateToIncomeR();
  }
});

function syncEphysToIncZ5(){
  var ephysEl = document.getElementById("Ephys");
  var z5El = document.getElementById("inc_Z5");

  if(!ephysEl || !z5El) return;

  var raw = String(ephysEl.textContent || "").replace(/,/g, "").trim();

  z5El.value = raw || "";

  if(typeof incomeCalc === "function"){
    incomeCalc();
  }
}

document.addEventListener("DOMContentLoaded", function(){
  syncEphysToIncZ5();

  var ephysEl = document.getElementById("Ephys");
  if(ephysEl){
    var observer = new MutationObserver(function(){
      syncEphysToIncZ5();
    });

    observer.observe(ephysEl, {
      childList: true,
      characterData: true,
      subtree: true
    });
  }
});